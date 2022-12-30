<?php

use core\render;
use core\controller;
use src\models\paymentsModel;
use src\models\acmModel;
use core\session;

final class paymentsController extends controller{

    private $paymentsM;

    public function __construct()
    {
        $this->paymentsM = new paymentsModel();

        $this->acmModel = new acmModel();
        
        $status = $this->acmModel->status();

        if((!$status || session::Read('USER')['Referrer'] == false ) && session::Read('USER')['Superuser'] !== 'tYES'){
            render::default('deny.php');
            die();
        }

    }


    public function index(){
        render::view('payments/index.php',['controllerName'=>'payments']);
    }

    public function getall(){
        $all = $this->paymentsM->getAll(session::Read('USER')['BusinessUnits']);
        render::json()->out($all);
    }



    // Get all business units saved on user login
    public function getbusinessunits(){
        render::json()->out(session::Read('USER')['BusinessUnits']);
    }



    public function savepaymentedit(){
        $save = $this->paymentsM->updatePaymentMethod($this->getJson());

        if($save){
            render::json()->message('Metodo modificado con éxito')->out();
        }

        render::json(400)->message('No se pudo guardar los cambios')->out();
    }





    public function createnewpayment(){
        $save = $this->paymentsM->createPaymentMethod($this->getJson());

        if($save){
            render::json()->message('Metodo creado con éxito')->out();
        }

        render::json(400)->message($this->paymentsM->message)->out();
    }



    public function findentity(){
        $find = $this->paymentsM->findentityPayment($this->getJson());

        render::json()->out($find);
    }

}