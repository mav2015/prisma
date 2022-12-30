<?php

use core\render;
use src\models\acmModel;

final class acmController
{

    private $acmM;

    public function __construct()
    {
        $this->acmM = new acmModel();
    }

    

    public function login()
    {
        render::view('acm/login.php');
    }



    public function checklogin()
    {
        $login = $this->acmM->login($_POST['user'], $_POST['password']);
        render::json()->message($this->acmM->message)->out($login);
    }




    public function logout()
    {
        $this->acmM->logout();
        route('acm/login', true,2);
        die();
    }
}
