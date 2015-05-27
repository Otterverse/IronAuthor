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

//   if (Auth::user()->contestant) {
//     return Redirect::to('/story/view/0');
//   }elseif(Auth::user()->reviewer){
//     return Redirect::to('/reviews');
//   }
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


Route::get('/admin/user', array('before' => 'auth|admin', 'uses' => 'UserController@admin'));
Route::post('/admin/user', array('before' => 'auth|admin', 'uses' => 'UserController@edit'));
Route::get('/user/{id}/story', array('before' => 'auth|admin', 'uses' => 'UserController@story'));
Route::get('/admin/contest', array('before' => 'auth|admin', 'uses' => 'ContestController@settings'));
Route::post('/admin/contest', array('before' => 'auth|admin', 'uses' => 'ContestController@save'));



Route::get('/user/settings', array('before' => 'auth', 'uses' => 'UserController@settings'));
Route::post('/user/settings', array('before' => 'auth', 'uses' => 'UserController@save_settings'));


Route::get('/story/edit/{id}', array('before' => 'auth|contestant', 'uses' => 'StoryController@edit'));
Route::post('/story/edit/{id}', array('before' => 'auth|contestant',  'uses' =>  'StoryController@save'));
Route::get('/story/delete/{id}', array('before' => 'auth|admin',  'uses' => 'StoryController@delete'));

Route::get('/story/view/{id}', array('uses' => 'StoryController@view'));

Route::get('/story/list/{phase?}', array('before' => 'auth|judge', 'uses' => 'StoryController@storylist'));

Route::get("/reviews", array('before' => 'auth|reviewer', 'uses' => 'ReviewController@home'));
Route::get("/review/new", array('before' => 'auth|reviewer', 'uses' => 'ReviewController@newReview'));
Route::get("/review/view/{id}", array('before' => 'auth', 'uses' => 'ReviewController@view'));

Route::get("/review/edit/{id}", array('before' => 'auth|reviewer', 'uses' => 'ReviewController@edit'));
Route::post("/review/edit/{id}", array('before' => 'auth|reviewer', 'uses' => 'ReviewController@save'));

Route::get("/review/delete/{id}", array('before' => 'auth|reviewer', 'uses' => 'ReviewController@delete'));

Route::get('/story/publiclist', array('uses' => 'StoryController@public_list'));

