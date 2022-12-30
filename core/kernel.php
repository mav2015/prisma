<?php

// hide errors and warnings
ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);
error_reporting(0);

// Show errors if debug
if (DEBUG) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}


/**
 * Call autoloader
 */
require_once dirname(__FILE__, 2) . '/core/autoloader.php';


/**
 *  CONSOLE SECTION
 * 
 */
if (defined('CONSOLE'))
{
  die();
}


/**
 *  API SECTION
 * 
 */

if (preg_match('/^(api\.)/', $_SERVER["HTTP_HOST"])) {

    define("KERNEL", "API");

    header("Access-Control-Allow-Origin:*");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST");
    header("Allow: GET,POST,PUT,DELETE,PATCH");

    // Bad request. Only POST method is allow
    //$_SERVER['REQUEST_METHOD'] !== 'POST' && core\render::json(400)->message('Only POST method is allow')->out();
    
    // call api router
    require_once dirname(__FILE__, 2) . '/core/router-api.php';
    die();
}


/**
 *  HTML SECTION
 * 
 */
// call html router
require_once dirname(__FILE__, 2) . '/core/router-html.php';
define("KERNEL", "HTML");