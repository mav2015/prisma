<?php


/**
 * Project route
 */
function route(string $path = "")
{
    return APIURL . str_replace("//","/", "/".$path);
}



/**
 * cleaning URL 
 */
$filteredUrl = isset($_GET['url']) == null ? '' : filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
$route = explode('/', strtolower($filteredUrl));


/**
 * 
 * controllers instantiation
 * 
 */
$file = dirname(__FILE__, 2) . "/src/api_controllers/" . $route[0] . "Controller.php";

/**
 * checking file exists
 */
if (is_readable($file)) {

	/**
	 * call instance
	 */
	require $file;

	$instance = $route[0] . 'Controller';
	$instance = new $instance;

	if (isset($route[1]) && method_exists($instance, $route[1])) {

		if (array_key_exists(2, $route)) {
				
			call_user_func_array([$instance, $route[1]], array_slice($route, 2));
			die();
		}

		call_user_func([$instance, $route[1]]);
		die();
	}
}

/**
 * if controller or method does not exist call the 404 error page
 */
core\render::json(404)->message('Bad EndPoint')->out();