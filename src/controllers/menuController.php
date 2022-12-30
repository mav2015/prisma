<?php

use core\render;
use src\models\acmModel;

final class menuController{

    private $acmM;

    public function __construct()
    {
        $this->acmM = new acmModel();
    }

    public function index(){

        $status = $this->acmM->status();

        if(!$status){
            render::json()->out(false);
        }

        render::json()->out($status);
    }
}