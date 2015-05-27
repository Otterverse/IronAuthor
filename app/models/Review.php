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

	public function can_edit()
	{
		$contest = Contest::find(1);
		if($this->phase == $contest->current_phase || ($this->phase == "Public" && $contest->publicreviews))
		{
			return true;
		}
		return false;
	}

}
