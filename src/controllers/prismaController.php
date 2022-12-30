<?php

use core\render;
use src\models\prismaModel;
use src\models\userbranchModel;
use core\session;

final class prismaController{

    private $prismaModel;

    public function __construct()
    {
         $this->prismaModel = new prismaModel();

    }



    public function index(){
        render::view('prisma/index.php',['controllerName'=>'prisma']);
    }


    public function getdata(){
       
          //$data = $this->prismaModel->get_all();
          //render::json()->out($data);
          $userModel = new userbranchModel();
          $data = $userModel->getAllBranchs('dseme');
          render::json()->out($data);
          //return $data;

    }

    
    public function test(){

        var_dump(session::Read('USER')['username']);
    }

}