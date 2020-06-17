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

    if ($review)
    {
      if ($review && $review->user->id == $user->id || $user->admin)
      {
        return View::make('review_edit', compact('review'));
      }
      return Response::make('Permission Denied!', 403);
    }
    return Response::make('Invalid story ID!', 404);
	}

  public function delete($review_id)
	{
    $user = Auth::user();
    $review = Review::find($review_id);

    if(!$review)
    {
      return Response::make('Invalid Review ID!', 404);
    }

    if ($review->user->id == $user->id && $user->reviewer) {
      $review->delete();
      return Redirect::to('/reviews')->with('message', "Review Deleted");
    }

    if($user->admin)
    {
      $story_id = $review->story()->first()->id;
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
      return View::make('review_home', compact('reviews'));
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

      foreach($user->reviews()->get() as $review)
      {
         if ($review->pending) {
           $pending = $review->id;
           break;
         }
      }

      if($pending)
      {
        return Redirect::to('/review/edit/' . $pending);
      }



      if($user->reviews()->count() < Contest::find(1)->max_reviews) {

        $stories = Story::whereNotIn('id', $user->reviews()->lists('story_id') )->whereNotIn('id', [$user->story->id] )->get();

        $stories = $stories->filter(function ($story) {
          if($story->reviews()->count() < Contest::find(1)->max_reviews) { return true; }
        });

      }


        if(is_null($stories) || $stories->isEmpty()){
          return Response::make("No stories left for you to review!", 200);
        }

        $stories->values();

        $stories->sortBy(function($story){
          return $story->reviews()->count();
        });

        $low_count = $stories->first()->reviews()->count();

        $stories = $stories->filter(function ($story) use($low_count){
          if($story->reviews()->count() == $low_count) { return true; }
        });

        $stories->values();

        $rand = rand( 0, $stories->count() - 1);
        $story = $stories->offsetGet( $rand );

        $review = new Review;
        $review->pending = 1;
        $review->story()->associate($story);
        $review->user()->associate($user);
        $review->save();

        return Redirect::to('/review/edit/' . $review->id);
    }
    return Response::make("Permission Denied!", 403);
  }


}
