<?php

class ContestController extends BaseController {

  public function settings()
  {
    $contest = Contest::find(1);
    return View::make('contest_settings', compact('contest'));
  }


  public function save()
  {
    $contest = Contest::find(1);

    $data = Input::all();

		$rules = array
		(
			'general_rules' => array('required'),
			'secret_rules' => array('required'),
      'start_time' => array('date'),
      'stop_time' => array('date', 'required_without:duration'),
      'duration' => array('integer', 'min:0','required_without:stop_time'),
      'grace_time' => array('required', 'integer', 'min:0'),
      'max_reviews' => array('required', 'integer', 'min:0')
		);

		$validator = Validator::make($data, $rules);

		if ($validator->passes())
		{
      print_r('Test');
      $contest->general_rules = $data['general_rules'];
      $contest->secret_rules = $data['secret_rules'];
      $contest->max_reviews = $data['max_reviews'];
      $contest->grace_time = $data['grace_time'];

      if ($data['start_time']){
        $contest->start_time = strtotime($data['start_time']);
      }else{
        $contest->start_time = time();
      }

      if ($data['stop_time']){
        $contest->stop_time = strtotime($data['stop_time']);
      }else{
        $contest->stop_time = strtotime('+' . $data['duration'] . 'minutes', $contest->start_time);
      }

      if (Input::get('locked'))
      {
        $contest->locked = 1;
      }else{
        $contest->locked = 0;
      }

      if (Input::get('publiclist'))
      {
        $contest->publiclist = 1;
      }else{
        $contest->publiclist = 0;
      }

     $contest->save();
      return Redirect::to('/');
     }
     return Redirect::to('/admin/contest')->withErrors($validator)->withInput();

  }

}
