<?php

require_once 'Model.php';

class Comment extends Model
{
	public $id = null;
	public $post_id = null;
	public $table = 'comments';
	public $fillables = ['post_id', 'body'];

	function __construct($input = null)
	{
		$this->body = $input['body'];
		if (isset($input['id'])) {
			$this->id = $input['id'];
		}
		if (isset($input['post_id'])) {
			$this->post_id = $input['post_id'];
		}
	}

	public function create($input)
	{
		return new Comment($input);
	}

	public static function make($input)
	{
		return new Comment($input);
	}

	public function post()
	{
		return $this->belongsTo('posts', $this->post_id);
	}
}