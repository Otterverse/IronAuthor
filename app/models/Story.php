<?php

class Story extends Eloquent
{

	public function reviews()
	{
		return $this->hasMany('Review');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}
