<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', array('before' => 'auth', function()
{
	return View::make('home');
}));

Route::get('/register', array('before' => 'guest', function()
{
    return View::make('register');
}));

Route::post('/register', array('before' => 'guest', 'uses' => 'UserController@register'));



Route::get('/login', array('before' => 'guest', function()
{
		return View::make('login');
}));

Route::post('/login', function()
{

	if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password'))))
	{
		return Redirect::intended('/');
	}else{
		return Redirect::to('/login')->with('message', 'Bad username or password!');
	}
});


Route::get('/logout', function()
{
		Auth::logout();
		return Redirect::to('/');
});


Route::get('/story/edit', array('before' => 'auth|contestant', 'uses' => 'StoryController@edit'));
Route::post('/story/edit', array('before' => 'auth|contestant',  'uses' =>  'StoryController@save'));
Route::get('/story/delete', array('before' => 'auth|admin',  'uses' => 'StoryController@delete'));

Route::get('/story/view', array('before' => 'auth', 'uses' => 'StoryController@view'));