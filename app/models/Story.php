<?php

class Story extends Eloquent
{

	public function reviews($phase = NULL)
	{
		if ($phase)
		{
			return $this->hasMany('Review')->where('phase','=', $phase);
		}
		return $this->hasMany('Review');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

}
