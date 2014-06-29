<?php

class StoryController extends BaseController {
    
	public function save()
	{	
	
		$data = Input::all();
		
		//Recover from login timeout or save failure
		if (Session::pull('login_recover'))
		{
			$data['title'] = Session::get('title');
			$data['body'] = Session::get('body');
		}
				
		$user = Auth::user();

		$rules = array
		(
			'title' => array('required', 'min:2', 'max:256'),
			'body' => array('required')
		);
		
		$validator = Validator::make($data, $rules);
		
		if ($validator->passes())
		{						
			$story = ($user->story) ? $user->story : new Story;
			$story->title = $data['title'];
			$story->body = $data['body'];
			$story->user()->associate($user);
			$story->save();
			Session::forget('title');
			Session::forget('body');
			Session::forget('save_story');
			
			return Redirect::to('/story/view');
		}
		
		Session::put('save_story', 1);
		Session::put('title', $data['title']);
		Session::put('body', $data['body']);
		return Redirect::to('/story/edit')->withErrors($validator);
		
	}
		
	public function edit()
	{
		//Recover from login timeout
		if (Session::get('login_recover'))
		{
			return $this->save();
		}

		$story = (Auth::user()->story) ? Auth::user()->story : new Story;
		$data = array('title' => $story->title, 'body' => $story->body);
		
		if (Session::pull('save_story'))
		{
			$data['title'] = Session::pull('title');
			$data['body'] = Session::pull('body');
		}
		
		return View::make('story_edit', compact('data'));
	}
	
	public function view()
	{
		$story = Auth::user()->story;
		if ($story)
		{
			return View::make('story_view', compact('story'));
		}
		return Redirect::to('/story/edit');
	}
	
	public function delete()
	{			
		$user = Auth::user()->story->delete();
		return Redirect::to('/story/edit');
	}

}