<?php 
	
  
	require "model/base.php";
	require "helper/lib.php";
	require "helper/router.php";

	require "http/web.php";

	define("LINECESS", @DB::find("cloud", "useridx=? && agree=?", [USER['idx'],"1"]));
	
	
    include_once "Y:/xampp/htdocs/web/session/log_block_v2.php";
    logging();

	$uri = explode("/", unslash(urldecode($_SERVER["REQUEST_URI"])));
	$method = $_SERVER['REQUEST_METHOD'];

	foreach ($route[$method] as $route => $fn) {
		$route = explode("/", unslash(urldecode($route)));
		$param = [];

		if (count($route) != count($uri)) {
			continue;
		}

		foreach ($route as $key => $value) {
			if ($value == "$") {
				$param[] = $uri[$key];
				continue;
			}

			if ($value != $uri[$key]) {
				continue 2;
			}
		}
		return $fn(...$param);
	}
	view_data("404");


 ?>