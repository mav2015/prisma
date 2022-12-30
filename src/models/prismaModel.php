<?php namespace src\models;

use core\dbManager;
use core\postman;
use core\session;

class prismaModel extends dbManager{

    

    public function __construct(){
        parent::__construct();
    }


    public function get_all(){
        
        /*
        $user = session::Read('USER')['username'];
        var_dump($user);
        $query = "/sml.svc/YUH_SUCUSUARIO?$"."filter=USER_CODE eq '{$user}'&\$select=AliasName,Street,BPLId";
        var_dump($query);
        $query = postman::getAll($query);
        
        return $query;
        */

    }



}