<?php namespace database;

use core\dbCrafter;

class db1663682735_factor_list{

    private $crafter;
    
    public function __construct()
    {        
        $this->crafter = new dbCrafter("factor_list");
    }
    

    public function install(){
        $this->crafter->craft(function($column){
            $column->id();
            $column->idnumber('suc_id')->nullable(false,0);
            // $column->string('item_code')->nullable(false);
            $column->float('factor')->nullable(false,1);
            // $column->trace();
        });

        $this->crafter->put([
            "suc_id"=>17,
            // "item_code"=>"M0001200850",
            "factor"=>1.05
        ]);
        $this->crafter->put([
            "suc_id"=>14,
            // "item_code"=>"M0001200857",
            "factor"=>1.07
        ]);
    }



    public function uninstall(){
        $this->crafter->uncraft();
    }
        
        

}