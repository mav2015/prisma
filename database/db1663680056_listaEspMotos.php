<?php namespace database;

use core\dbCrafter;

class db1663680056_listaEspMotos{

    private $crafter;
    
    public function __construct()
    {        
        $this->crafter = new dbCrafter("listaEspMotos");
    }
    

    public function install(){
        $this->crafter->craft(function($column){
            $column->id();
            $column->string('item_code')->nullable(false);
            $column->string('item_name')->nullable(false);
            $column->number('year')->unsigned()->nullable(false, 0000);
            $column->float('cost')->unsigned()->nullable(false,0);
            $column->float('tax')->unsigned()->nullable(false,0);
            $column->float('price')->unsigned()->nullable(false,0);
            // $column->trace();
        });


        $this->crafter->put([
            "item_code"=>"M0001200850",
            "item_name"=>'HONDA WAVE 110 S',
            "year"=>2022,
            "cost"=>350000,
            "tax"=>21,
            "price"=>423500
        ]);

        $this->crafter->put([
            "item_code"=>"M0001200857",
            "item_name"=>'HONDA WAVE 110 CAST DISK',
            "year"=>2022,
            "cost"=>350000,
            "tax"=>21,
            "price"=>423500
        ]);
        
        
        $this->crafter->put([
            "item_code"=>"M0001200850",
            "item_name"=>'HONDA WAVE 110 S',
            "year"=>2021,
            "cost"=>280000,
            "tax"=>21,
            "price"=>338800
        ]);        
    }



    public function uninstall(){
        $this->crafter->uncraft();
    }
        
        

}