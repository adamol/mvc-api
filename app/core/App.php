<?php

class App
{
	protected $controller = 'PostController';
	protected $method = 'index';
	protected $params = [];

	function __construct()
	{
		$url = $this->parseUrl();
		
		if (file_exists('../app/controllers/' . substr(ucfirst($url[0]),0,-1) . 'Controller.php')) {
			$this->controller = substr(ucfirst($url[0]),0,-1) . 'Controller';
			unset($url[0]);
		}

		require_once('../app/controllers/' . $this->controller . '.php');

		$this->controller = new $this->controller;
		
		if (isset($url[1]) && method_exists($this->controller, $url[1])) {
			$this->method = $url[1];
			unset($url[1]);
		}

		$this->params = $url ? array_values($url) : [];
		
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	public function parseUrl()
	{
		return array_slice(explode('/',$_SERVER['REQUEST_URI']), 5);
	}
}