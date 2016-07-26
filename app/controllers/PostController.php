<?php

class PostController extends Controller
{
	protected $post;

	function __construct()
	{
		$this->post = $this->model('Post');
	}
	
	public function index()
	{
		$posts = Post::all();

		$this->view('posts/index', ['posts' => $posts]);
	}

	public function show($id)
	{
		$post = Post::find($id);

		$comments = $post->comments();

		$this->view('posts/show', ['post' => $post, 'comments' => $comments]);
	}

	public function create()
	{
		Post::make([
			'title' => $_GET['title'],
			'body' => $_GET['body']
		])->save();
	}

	public function update($id)
	{
		Post::update($id, [
			'title' => $_GET['title'],
			'body' => $_GET['body']
		]);
	}

	public function delete($id)
	{
		Post::delete($id);
	}
}