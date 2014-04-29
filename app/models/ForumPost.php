<?php

use Carbon\Carbon;

class ForumPost extends Eloquent
{
	protected $table = 'forum_posts';
	protected $guarded = ['id'];

	public function user()
	{
		return $this->hasOne('user', 'id', 'user_id');
	}

	public function thread()
	{
		return $this->belongsTo('ForumThread', 'thread_id');
	}

	public function getDate() {
        if ($this->created_at->diffInDays() > 30) {
            return 'Posted at ' . $this->created_at->toFormattedDateString();
        } 
        else {
            return $this->created_at->diffForHumans();
        }
    }
}