<?php namespace database;

use core\dbCrafter;

class db1663683743_promotionalPrices{

    private $crafter;
    
    public function __construct()
    {        
        $this->crafter = new dbCrafter("promotionalPrices");
    }
    

    public function install(){
        $this->crafter->craft(function($column){
            $column->id();
            $column->string('item_code')->nullable(false);
            $column->idnumber('suc_id')->nullable(false,0);
            $column->string('item_property1')->nullable(false);
            $column->string('item_property2')->nullable(false);
            $column->float('factor')->nullable();
            $column->float('price')->unsigned()->nullable();
            $column->time('start');
            $column->time('expire');
            // $column->trace();
        });


        $this->crafter->put([
            'item_code' => "M0001200850",
            'suc_id' => 17,
            'item_property1' => 'year:2021',
            'factor' => 0.9,
            'start' => date('2022/m/d H:i:s'),
            'expire' => date('2022/11/d H:i:s')
        ]);
    }



    public function uninstall(){
        $this->crafter->uncraft();
    }
        
        

}