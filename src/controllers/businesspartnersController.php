<?php

use core\controller;
use core\render;
use src\models\businesspartnersModel;

final class businesspartnersController extends controller{

    private $businessPartnerM;

    public function __construct()
    {
        $this->businessPartnerM = new businesspartnersModel();
    }

    public function index(){
        render::view('businesspartners/index.php',['controllerName'=>'businesspartners']);
    }

    public function getall(){
        $all = $this->businessPartnerM->getAll();
        render::json()->out($all);
    }

    public function createnewuser(){
        $insert = $this->businessPartnerM->createNewPartner($this->getJson());

        if($insert == false){
            render::json(400)->message('No se pudo crear el socio de negocio')->out();
        }

        render::json()->message('Socio de negocio creado con éxito')->out($insert);
    }

}