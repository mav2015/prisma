<?php

use core\render;
use src\models\productsModel;
use src\models\acmModel;

final class productsController{

    private $productM,$acmModel;


    public function __construct()
    {   

        $this->acmModel = new acmModel();
        
        if(!$this->acmModel->status()){
            render::default('deny.php');
            die();
        }

        $this->productM = new productsModel();
    }

    public function getall(){

        if(isset($_GET['division']))$this->productM->division = $_GET['division'];
        if(isset($_GET['search']))$this->productM->search = $_GET['search'];

        $all = $this->productM->getAll();

        if($all){
            render::json()->out($all);
        }

        render::json(201)->message($this->productM->message)->out();
    }


}