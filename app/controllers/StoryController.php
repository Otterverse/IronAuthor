<?php

class StoryController extends BaseController {

	public function save($story_id)
	{

		$data = Input::all();
		$user = Auth::user();

		//Recover from login timeout or save failure
		if (Session::pull('login_recover'))
		{
			$data['title'] = Session::get('title');
			$data['body'] = Session::get('body');
		}


		$rules = array
		(
			'title' => array('required', 'min:2', 'max:256'),
			'body' => array('required')
		);

		$validator = Validator::make($data, $rules);

		if ($validator->passes())
		{
      if($story_id == 0 && $user->contestant)
      {
        $story = ($user->story) ? $user->story : new Story;
        $story_owner = $user;
      }elseif($story_id > 0 && $user->admin)
      {
        $story = Story::find($story_id);
        $story_owner = $story->user;
      }else
      {
        return Response::make('Permission denied!', 403);
      }


			$story->title = $data['title'];
			$story->body = $data['body'];
			$story->user()->associate($story_owner);
			$story->save();
			Session::forget('title');
			Session::forget('body');
			Session::forget('save_story');

			return Redirect::to("/story/view/$story_id");
		}

		Session::put('save_story', 1);
		Session::put('title', $data['title']);
		Session::put('body', $data['body']);
		return Redirect::to("/story/edit/$story_id")->withErrors($validator);

	}



	public function edit($story_id)
	{
    $user = Auth::user();
    if ($story_id == 0 && $user->contestant)
    {
      //Recover from login timeout
      if (Session::get('login_recover'))
      {
        return $this->save();
      }

      $story = ($user->story) ? $user->story : new Story;
      $data = array('title' => $story->title, 'body' => $story->body);

      if (Session::pull('save_story'))
      {
        $data['title'] = Session::pull('title');
        $data['body'] = Session::pull('body');
      }

    }elseif($story_id > 0 && $user->admin)
    {
      $story = Story::find($story_id);

      if(!$story)
      {
        return Response::make('Invalid story ID!', 404);
      }

      $data = array('title' => $story->title, 'body' => $story->body);
    }else
    {
      return Response::make('Permission denied!', 403);
    }
    return View::make('story_edit', compact('data'));
   }


	public function view($story_id)
	{
    $user = Auth::user();
    if ($story_id > 0)
    {
      if(!($user->judge || $user->admin || $user->reviewer))
      {
        return Response::make('Permission denied!', 403);
      }

      $story = Story::find($story_id);
      if ($story)
      {
        return View::make('story_view', compact('story'));
      }
      return Response::make('Invalid story ID!', 404);

    }elseif($user->contestant)
    {
    	$story = Auth::user()->story;
      if ($story)
      {
        return View::make('story_view', compact('story'));
      }
      return Redirect::to('/story/edit/0');
    }
	}

  public function storylist()
  {
    $stories = Story::all();

    foreach($stories as $story){
      $reviews = $story->reviews()->get();
      $reviews = $reviews->filter(function ($review) {
        return !$review->pending;
      });
      $count = $reviews->count();

      $tech = 0;
      $struct = 0;
      $impact = 0;
      $theme = 0;
      $misc = 0;

      foreach($reviews as $review){
        $tech += $review->technical_score;
        $struct += $review->structure_score;
        $impact += $review->impact_score;
        $theme += $review->theme_score;
        $misc += $review->misc_score;
      }

      $story->review_count = $count;
      $story->technical_score = ($count) ? number_format($tech / $count, 2) : 0;
      $story->structure_score = ($count) ? number_format($struct / $count, 2) : 0;
      $story->impact_score = ($count) ? number_format($impact / $count, 2) : 0;
      $story->theme_score = ($count) ? number_format($theme / $count, 2) : 0;
      $story->misc_score = ($count) ? number_format($misc / $count, 2): 0;
      $story->total_score = ($count) ? number_format(($misc + $struct + $impact + $theme + $misc ) / $count, 2) : 0;

    }

    return View::make('story_list', compact('stories', 'scores'));
  }

	public function delete($story_id)
	{
		//$user = Auth::user()->story->delete();
		return Response::make("Story $story_id deleted!", 200);
	}

}
