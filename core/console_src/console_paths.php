<?php

namespace core\console_src;


/**
 * paths must start with './' and end with the directory separator '/'
 * example: './config/'
 */
trait console_paths
{
    public $controllerFolder = "./src/controllers/";
    public $apiControllerFolder = "./src/api_controllers/";
    public $modelFolder = "./src/models/";
    public $viewFolder = "./src/views/";
    public $configFolder = "./config/";
    public $htaccessFile = "./.htaccess";    
    public $hostauthFile = "./hostauth.json";
    public $defaultHTMLFolder = "./src/defaultHTML/";
    public $databaseFolder = "./database/";
    public $uploadFolder = "./public/assets/upload/";


    public function nspace(string $path): string
    {
        // prepare the route to use as namespace
        preg_match('/^\.\/([a-zA-Z.\/]+)\/$/', $this->$path, $match);
        $path = str_replace('/', '\\', $match[1]);
        return $path;
    }
}
