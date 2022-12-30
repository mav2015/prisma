<?php

use core\render;

final class dashboardController{


    public function __construct()
    {
        render::default('deny.php');
        die();
    }

    public function index(){
        
        render::view('dashboard/index.php',['controllerName'=>'dashboard']);
    }
}