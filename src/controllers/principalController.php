<?php

use core\render;

final class principalController{

    public function index(){

        render::view('principal/index.php',['data'=>'Principal']);
    }
}