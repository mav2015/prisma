<?php

namespace src\models;

use core\dbManager;
use core\postman;
use core\session;

class paymentsModel extends dbManager
{

    public $endpoint = '/ARGNS_POPAYMENTMEA', $message;


    public function __construct()
    {
        parent::__construct();
    }


    
    /**
     * getAll
     *
     * @param  array $businessUnits
     * @return void
     */
    public function getAll(array $businessUnits)
    {


        array_push($businessUnits,'Financieras');

        if(!$businessUnits || !in_array($_GET['division'],$businessUnits))return false;
        
        $divisionType = (strtoupper($_GET['division'][0]) == 'F')? 'Financiera' : strtoupper($_GET['division'][0]);


        // Principal query with order and filter
        $query = $this->endpoint . "?\$select=Code,Name,U_Quotas,U_Surcharge,Canceled&\$orderby=Name asc&\$filter=contains(U_Type, '". $divisionType ."Code')";



        $filters = [];

        // applying Name Filter
        if (isset($_GET['search']) && $_GET['search'] > '') {

            $cardName = explode(" ", ucwords($_GET['search']));

            // Name filter on search
            array_push($filters, "contains(Name, '" . implode("') and contains(Name, '", $cardName). "')");
        }


        // check if you have filters to apply
        if (count($filters) > 0) {
            $query = $query . ' and ' . implode(' and ', $filters);
        }
        

        // var_dump($query); die();

        
        // execute query
        $query = postman::getAll($query);

        return $query;
    }



    /**
     *  Find entity
     * 
     */
    public function findentityPayment($data){

        if($data['type'] === 'Financiera'){
            $division = "Financiera";
        }else{
            $division = strtoupper($data['division'][0]);
        }

        $query = postman::getAll("ARGNS_POTYPEPAYMEA?\$select=Code,Name&\$filter=contains(Code,'". $division ."Code') and contains(Name,'". ucwords($data['name']) ."')"); 

        return $query;
    }



    /**
     *  Update payments methods
     */
    public function updatePaymentMethod($data){

        $query = $this->endpoint."('".$data['Code']."')";

        unset($data['Code']);

        $query = postman::send('PATCH',$query,$data);

        if($query[0] == 204){
            return true;
        }

        return false;
    }



    /**
     * Entity code generator
     */
    public function entityCodeGenerator($data){
        $name = explode(' ',explode(';',$data['EntityName'])[0]);
        
        $newName = '';

        $pos = 0;
        foreach ($name as $key) {
            if($pos == 0){ 
                $newName = $key; 
            }else{
                $newName .= strtoupper($key[0]);
            }
            $pos ++;
        }

        return strtoupper($data['EntityType'][0]).$newName.$data['Division'][0].'Code';
    }


    /**
     * Method code generator
     */
    public function methodCodeGenerator($data){
        $name = explode(' ',explode(';',$data['EntityName'])[0]);
        
        $newName = '';

        $pos = 0;
        foreach ($name as $key) {
            if($pos == 0){ 
                $newName = $key; 
            }else{
                $newName .= strtoupper($key[0]);
            }
            $pos ++;
        }

        $interest = $data['Interest'] == 0 ? 'S':'';

        return $newName.$data['Division'][0].strtoupper($data['Description'][0]).$data['Quota'].$interest;
    }







    /**
     *  Create entity and payment method
     * 
     */
    public function createPaymentMethod($data){

        //EntityType, EntityName, Description, Quota, Interest, Division

        $entity = explode(';',$data['EntityName']);
        $entityName = $entity[0];
        $entityCode = $entity[1];
        $entityFullName = $data['EntityType'].' '.$entityName.' '.$data['Division'];


        /**
         * Creation of entity
         */
        if($entity[1] == 'NewEntity'){

            $entityCode = $this->entityCodeGenerator($data);

            $createEntity = postman::send('POST','ARGNS_POTYPEPAYMEA',[
                "Code"=>$entityCode,
                "Name"=>$entityFullName,
                "U_Type"=>$data['EntityType']
            ]);
            
            if($createEntity[0] != 201){
                $this->message = 'Falló al crear la entidad';
                return false;
            } 
        }



        /**
         * Creation payment method
         */
        $interest = $data['Interest'] == 0 ? ' Sin Interes':'';
        $methodName = $entityName.' '.$data['Description'].' '.$data['Quota'].$interest;

        $createPaymentMethod = postman::send('POST',$this->endpoint,[
            "Code"=> $this->methodCodeGenerator($data),
            "Name"=> $methodName,
            "U_Quotas"=>$data['Quota'],
            "U_Type"=>$entityCode,
            "U_Surcharge"=>$data['Interest']
        ]);

        if($createPaymentMethod[0] != 201){
            $this->message = 'Falló al crear el metodo de pago';
            return false;
        } 
            
        return true;
    }

}
