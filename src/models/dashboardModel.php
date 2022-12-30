<?php namespace src\models;

use core\dbManager;

class dashboardModel extends dbManager{

    private int $id;

    public function __construct(){
        parent::__construct();
    }


    public function get_id(){
        return $this->id;
    }

    public function set_id($id){
        $this->id = $id;
    }   

}