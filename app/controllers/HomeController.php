<?php

class ContestController extends BaseController {

	public function edit()
	{
    if(Auth::user()->admin){
      Contest::find(1);
		  return View::make('edit_contest', compact('contest'));
    }
    return Make::response("Permission Denied", 403);
	}

  public function save()
	{
    if(Auth::user()->admin)
    {
      $data = Input::all();
      $contest = Contest::find(1);


      $rules = array
		  (
			'title' => array('required', 'min:2', 'max:256'),
			'body' => array('required')
		  );

      $validator = Validator::make($data, $rules);

      if ($validator->passes())
      {
        $contest->rules = Input::get('rules');
        $contest->end_time = (Input::get('duration') * 3600) + time();
        $contest->locked = Input::get('locked');
      }
      return Redirect::to('/contest')->withErrors($validator);

	}
  return Make::response("Permission Denied", 403);
  }




}
