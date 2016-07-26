<?php

class Home extends Controller
{
	protected $user;

	function __construct()
	{
		$this->user = $this->model('User');
	}
	public function index($name = '')
	{
		$this->user->name = $name;

		$this->view('home/index', ['name' => $this->user->name]);
	}

	public function show($name = '')
	{
		$this->user->name = $name;

		$this->view('home/index', ['name' => $this->user->name]);
	}

}