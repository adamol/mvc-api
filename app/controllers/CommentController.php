<?php

class CommentController extends Controller
{
	protected $comment;

	function __construct()
	{
		$this->comment = $this->model('Comment');
	}
	
	public function index()
	{
		$comments = Comment::all();

		$this->view('comments/index', ['comments' => $comments]);
	}

	public function show($id)
	{
		$comment = Comment::find($id);

		$post = $comment->post();
		
		$this->view('comments/show', ['comment' => $comment, 'post' => $post]);
	}

	public function create()
	{
		Comment::make([
			'post_id' => $_GET['post_id'],
			'body' => $_GET['body']
		])->save();
	}

	public function update($id)
	{
		Comment::update($id, [
			'post_id' => $_GET['post_id'],
			'body' => $_GET['body']
		]);
	}

	public function delete($id)
	{
		Comment::delete($id);
	}
}