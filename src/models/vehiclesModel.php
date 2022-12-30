<?php namespace src\models;

use core\dbManager;
use core\postman;

class vehiclesModel extends dbManager{

    public $error;

    public function __construct(){
        parent::__construct();
    }

    /**
     * getByDomain
     *
     * @return void
     */
    public function getByDomain($data){
        $response = postman::send('GET','sml.svc/YUH_SERIESPRODUCTOSV2?$filter=contains(U_Patente,\''.strtoupper($data).'\')',[],5);

        if($response[0] == 200){
            return $response[1]['value'];
        }

        $this->error="No se encontraron coincidencias";
        return false;
    }

    
    /**
     * getByChasis
     *
     * @param  string $data chasis id
     * @return mixed
     */
    public function getByChasis(string $data){        
        $response = postman::send('GET','sml.svc/YUH_SERIESPRODUCTOSV2?$filter=contains(U_Chasis,\''.strtoupper($data).'\')',[],5);
       
        if($response[0] == 200){
            return $response[1]['value'];
        }
        $this->error="No se encontraron coincidencias";
        return false;
    }

        
    /**
     * getByInternalNumber
     *
     * @param  string $data internal id
     * @return void
     */
    public function getByInternalNumber(string $data){
        // $apply=groupby((U_Chasis,U_Motor,IntrSerial,ItemCode,ItemName,U_Patente,CardCode,CardName,Cellular,E_Mail,Address))&
        $response = postman::send('GET','sml.svc/YUH_SERIESPRODUCTOSV2?$filter=contains(IntrSerial,\''. strtoupper($data).'\')',[],5);

        if($response[0] == 200){
            return $response[1]['value'];
        }
        $this->error="No se encontraron coincidencias";
        return false;
    }

    
    /**
     * getByPartnerCode
     *
     * @param  string $data partner Code
     * @return void
     */
    public function getByPartnerCode(string $data){
        $response = postman::send('GET','sml.svc/YUH_SERIESPRODUCTOSV2?$select=*&$apply=groupby((U_Chasis,U_Motor,IntrSerial,ItemCode,ItemName,U_Patente))&$filter=contains(CardCode,\''.strtoupper($data).'\')',[],5);

        if($response[0] == 200){
            return $response[1]['value'];
        }
        $this->error="No se encontraron coincidencias";
        return false;
    }
 

}