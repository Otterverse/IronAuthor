<?php

class UserController extends BaseController {


    public function showProfile($id)
    {
        $user = User::find($id);

        return View::make('user.profile', array('user' => $user));
    }


	public function register()
	{
		$data = Input::all();

		$rules = array
		(
			'username' => array('required', 'regex:/^[A-Za-z0-9_-]{3,}$/', 'unique:users', 'max:64'),
			'email' => array('required', 'email', 'max:256'),
			'password' => array('required', 'confirmed'),
      'fimfic' => array('url')
		);

		$validator = Validator::make($data, $rules, array(
      'username.regex' => 'Username must be at least three characters and only contain alphanumeric characters, underscores, and/or dashes.',
      'fimfic.url' => "User Page should be a proper URL. Example: http://fimfiction.net/user/Example"
    ));

		if ($validator->passes())
		{
			$user = new User;
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->fimfic = Input::get('fimfic');
			$user->want_feedback = Input::get('want_feedback');
			$user->password = Hash::make(Input::get('password'));
			$user->contestant = true;
			$user->reviewer = false;
			$user->judge = false;
			$user->admin = false;
			$user->save();

			return Redirect::to('/login')->with('message', 'User created, please login.');
		}

		return Redirect::to('/register')->withErrors($validator)->withInput();

    }

  public function admin()
  {
    $users = User::all();
    return View::make('admin_user', compact('users'));

  }

  public function edit()
  {
    $data = Input::all();

    foreach (User::all() as $user)
    {
      $id = $user->id;
      $user->email = Input::get("email_$id");
      $user->fimfic = Input::get("fimfic_$id");
      $user->want_feedback = (Input::get("want_feedback_$id") == 1) ? 1 : 0;
      $user->admin = (Input::get("admin_$id") == 1) ? 1 : 0;
      $user->judge = (Input::get("judge_$id") == 1) ? 1 : 0;
      $user->reviewer = (Input::get("reviewer_$id") == 1) ? 1 : 0;
      $user->contestant = (Input::get("contestant_$id") == 1) ? 1 : 0;
			if (Input::get("newpass_$id"))
      {
        $user->password = Hash::make(Input::get("newpass_$id"));
      }

      $user->save();
    }

    return Redirect::to('/admin/user')->with('message', 'Users updated!');

  }

  public function story($user_id)
  {
    $user = User::find($user_id);
    $story = ($user->story) ? $user->story : new Story;
    $story->user()->associate($user);
	$story->title = ($story->title) ? $story->title : 'Placeholder Title';
	$story->body = ($story->body) ? $story->body : 'Placeholder';
	  $story->save();
    return Redirect::to('/story/view/' . $story->id);
  }



  public function save_settings()
	{
		$data = Input::all();

		$rules = array
		(
			'email' => array('required', 'email', 'max:256'),
			'password' => array('confirmed'),
      'fimfic' => array('url'),
		);

		$validator = Validator::make($data, $rules, array(
      'username.regex' => 'Username must be at least three characters and only contain alphanumeric characters, underscores, and/or dashes.',
      'fimfic.url' => "User Page should be a proper URL. Example: http://fimfiction.net/user/Example"
      ));

		if ($validator->passes())
		{
			$user = Auth::user();
			$user->email = Input::get('email');
			$user->fimfic = Input::get('fimfic');
			$user->want_feedback = Input::get('want_feedback');
      if (Input::get('password'))
      {
			  $user->password = Hash::make(Input::get('password'));
      }
			$user->save();

			return Redirect::to('/')->with('message', 'Settings Saved!');
		}

		return Redirect::to('/user/settings')->withErrors($validator)->withInput();

    }

  public function settings()
  {
    $user=Auth::user();
    return View::make('user_settings', compact('user'));
  }


}
