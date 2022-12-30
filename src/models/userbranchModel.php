<?php namespace src\models;

use core\dbManager;
use core\postman;

class userbranchModel extends dbManager{

    public $error;


    public function __construct(){
        parent::__construct();
    }

    


    /**
     * getAllBranchs
     *
     * @param  mixed $userCode
     * @return void
     */
    public function getAllBranchs(string $userCode){

        $filter = '?$filter=USER_CODE eq \''.$userCode.'\'';

        $response = postman::send('GET','/sml.svc/YUH_SUCUSUARIO'.$filter,[],0);

        if($response[0] == 200){
            return $response[1]['value'];
        }

        $this->error="No se encontraron coincidencias";
        return false;
    }

    
    
    /**
     * getWarehouses
     *
     * @param  mixed $bplid
     * @return void
     */
    public function getWarehouses(int $bplid){
        $response = postman::send('GET','/Warehouses?$select=WarehouseCode&$filter=BusinessPlaceID eq '.$bplid.' and U_DepIntermSuc eq \'N\' and Inactive eq \'tNO\'',[],0);

        if($response[0] == 200){
            return $response[1]['value'];
        }

        $this->error="No se encontraron coincidencias";
        return false;
    }

}