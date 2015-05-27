<?php

class ReviewController extends BaseController {

  public function view($review_id)
	{
    $user = Auth::user();
    $review = Review::find($review_id);

    if(!$review)
    {
      return Response::make('Invalid Review ID!', 404);
    }

    if ($review->pending && $review->user->id == $user->id && $user->reviewer) {
      return Redirect::to('/review/edit/' . $review_id);
    }

    if($user->admin || $user->judge || ($review->user->id == $user->id && $user->reviewer))
    {
      return View::make('review_view', compact('review'));
    }
    return Response::make('Permission Denied!', 403);
  }


  public function edit($review_id)
	{
    $user = Auth::user();
    $review = Review::find($review_id);
    $contest = Contest::find(1);

    if ($review)
    {
      if ($review && $review->user->id == $user->id || $user->admin)
      {
        if($review->can_edit)
        {
          return Response::make('Reviews for '. $review->phase . ' can no longer be modified.', 403);
        }
        return View::make('review_edit', compact('review'));
      }
      return Response::make('Permission Denied!', 403);
    }
    return Response::make('Invalid review ID!', 404);
	}

  public function delete($review_id)
	{
    $user = Auth::user();
    $review = Review::find($review_id);
    $contest = Contest::find(1);

    if(!$review)
    {
      return Response::make('Invalid Review ID!', 404);
    }

    if ($review->user->id == $user->id && $user->reviewer) {

      if($review->phase != $contest->current_phase){
        return Response::make('Reviews for '. $review->phase . ' can no longer be modified.', 403);
      }

      $review->delete();
      return Redirect::to('/reviews')->with('message', "Review Deleted");
    }

    if($user->admin)
    {
      $story_id = $review->story->first()->id;
      $review->delete();
      return Redirect::to('/story/view/' . $story_id)->with("message", "Review Deleted");
    }
    return Response::make('Permission Denied!', 403);
  }


  public function home()
  {
    $user = Auth::user();

    if ($user->reviewer)
    {
      $reviews = $user->reviews()->get();

      if($user->contestant)
      {
        $reviews_remaining = Contest::find(1)->required_reviews - $user->reviews()->count();
      }

      return View::make('review_home', compact('reviews', 'reviews_remaining'));
    }
    return Response::make('Permission Denied!', 403);
  }


public function save($review_id)
	{

		$data = Input::all();
		$user = Auth::user();

    $review = Review::find($review_id);

    if(!$review)
    {
      Return Response::make('Invalid Review ID!', 404);
    }


		$rules = array
		(
			'technical_score' => array('required', 'numeric', 'between:0,5'),
			'structure_score' => array('required', 'numeric', 'between:0,5'),
			'impact_score' => array('required', 'numeric', 'between:0,5'),
			'theme_score' => array('required', 'numeric', 'between:0,5'),
			'misc_score' => array('required', 'numeric', 'between:0,5'),
			'notes' => array('required')
		);

		$validator = Validator::make($data, $rules);

		if ($validator->passes())
		{
      if($user->admin || ($review->user->id == $user->id && $user->reviewer))
      {
        $review->notes = $data['notes'];
        $review->technical_score = $data['technical_score'];
        $review->structure_score = $data['structure_score'];
        $review->impact_score = $data['impact_score'];
        $review->theme_score = $data['theme_score'];
        $review->misc_score = $data['misc_score'];
        $review->pending = 0;
        $review->save();

        return Redirect::to("/review/view/$review_id");
      }else
      {
          return Response::make('Permission Denied!', 403);
      }
    }
		return Redirect::to("/review/edit/$review_id")->withErrors($validator)->withInput();
	}

  public function newReview()
  {
    $user = Auth::user();
    $contest = Contest::find(1);
    if($user->reviewer)
    {


      $pending = '';

      foreach($user->reviews($contest->current_phase)->get() as $review)
      {
        if ($review->pending) {
          return Redirect::to('/review/edit/' . $pending->id);
        }
      }

      if(!$user->can_review())
      {
        return Response::make("You are not a reviewer for this phase.", 403);
      }


        $stories = Story::whereNotIn('id', $user->reviews()->lists('story_id'))->get();

        $stories = $stories->filter(function ($story) use($contest){
          if($story->phase == $contest->current_phase { return true; }
        });

        $stories->values();

        $stories->sortBy(function($story) use($contest){
          return $story->reviews($contest->current_phase)->count();
        });

        $low_count = $stories->first()->reviews($contest->current_phase)->count();

        $stories = $stories->filter(function ($story) use($low_count, $contest){
          if($story->reviews($contest->current_phase)->count() == $low_count) { return true; }
        });

        $stories->values();

        $rand = rand( 0, $stories->count() - 1);
        $story = $stories->offsetGet( $rand );

        $review = new Review;
        $review->pending = 1;
        $review->phase = $user->review_phase;
        $review->story()->associate($story);
        $review->user()->associate($user);
        $review->save();

        return Redirect::to('/review/edit/' . $review->id);
    }
    return Response::make("Permission Denied!", 403);
  }


}
