<?php

class Review extends Eloquent
{
  public function user()
	{
		return $this->belongsTo('User');
	}

  public function story()
	{
		return $this->belongsTo('Story');
	}
}
