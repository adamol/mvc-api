<?php

require_once 'Model.php';

class Post extends Model
{
	public $id = null;
	public $table = 'posts';
	public $fillables = ['title', 'body'];

	function __construct($input = null)
	{
		if (isset($input['id'])) {
			$this->id = $input['id'];
		}
		$this->title = $input['title'];
		$this->body = $input['body'];
	}

	public function create($input)
	{
		return new Post($input);
	}

	public static function make($input)
	{
		return new Post($input);
	}

	public function comments()
	{
		return $this->hasMany('comments', 'post_id');
	}
}