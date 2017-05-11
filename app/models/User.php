<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface{

	use UserTrait;
	protected $table = 'users';
	protected $hidden = array('password', 'remember_token');

	public function story()
	{
		return $this->hasOne('Story');
	}

  public function reviews()
	{
		return $this->hasMany('Review');
	}

}
