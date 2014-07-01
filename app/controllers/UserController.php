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
			'username' => array('required', 'regex:/^[A-Za-z0-9_-]{3,}$/', 'unique:users'),
			'email' => array('required', 'email'),
			'password' => array('required', 'confirmed')
		);

		$validator = Validator::make($data, $rules, array('username.regex' => 'Username must be at least three characters and only contain alphanumeric characters, underscores, and/or dashes.') );

		if ($validator->passes())
		{
			$user = new User;
			$user->username = Input::get('username');
			$user->email = Input::get('email');
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
      $user->admin = (Input::get("admin_$id") == 1) ? 1 : 0;
      $user->judge = (Input::get("judge_$id") == 1) ? 1 : 0;
      $user->reviewer = (Input::get("reviewer_$id") == 1) ? 1 : 0;
      $user->contestant = (Input::get("contestant_$id") == 1) ? 1 : 0;
      $user->save();
    }

    return Redirect::to('/admin/user')->with('message', 'Users updated!');

  }



}
