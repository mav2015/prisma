<?php

namespace src\models;

use core\dbManager;
use core\postman;

class businesspartnersModel extends dbManager
{

    private $endpoint = 'BusinessPartners';

    public function __construct()
    {
        parent::__construct();
    }



    /**
     *  Selected fields
     * 
     * CardType,CardName,Address,ZipCode,Phone1,Phone2,FederalTaxID,PriceListNum,Currency,Cellular,City,Country,EmailAddress
     * Frozen
     */



    /**
     *  This method use filters through GET verbs:
     * 
     *  $_GET['cardname'], $_GET['cardcode'], $_GET['cardtype'], $_GET['federaltaxid']
     *  
     */
    public function getAll()
    {
        $filters = [];

        $query = $this->endpoint . '?$select=CardCode,CardName,Address,ZipCode,Phone1,FederalTaxID,PriceListNum,Currency,Cellular,City,Country,EmailAddress,Frozen,FrozenFrom,FrozenTo,Valid';
        // $query = $this->endpoint . '?$select=CardType,CardName,Address,ZipCode,Phone1,Phone2,FederalTaxID,PriceListNum,Currency,Cellular,City,Country,EmailAddress,Frozen,FrozenFrom,FrozenTo,Valid';
        // $query = $this->endpoint.'?$select=*'; //all fields

        // default settings
        //$_GET['cardtype'] = 'cCustomer';


        // applying Name Filter
        if (isset($_GET['cardname']) && $_GET['cardname'] > ''){
            $cardName = explode(" ", strtoupper($_GET['cardname']));
            $nameFilter = "contains(CardName, '". implode("') and contains(CardName, '", $cardName) ."')";

            array_push($filters, $nameFilter);
        } 


        array_push($filters, "CardType eq 'cCustomer'");

        if (isset($_GET['cardcode']) && $_GET['cardcode'] > '') array_push($filters, "CardCode eq '{$_GET['cardcode']}'");

        // if (isset($_GET['cardtype']) && $_GET['cardtype'] > '') array_push($filters, "CardType eq '{$_GET['cardtype']}'");

        if (isset($_GET['cellular']) && $_GET['cellular'] > '') array_push($filters, "contains(Cellular, '{$_GET['cellular']}')");

        if (isset($_GET['federaltaxid']) && $_GET['federaltaxid'] > '') array_push($filters, "contains(FederalTaxID, '" . str_replace('.', '', $_GET['federaltaxid']) . "')");


        // check if you have filters to apply
        if (count($filters) > 0) {
            $query = $query . '&$filter=' . implode(' and ', $filters);
        }

        // execute query
        $query = postman::send('GET', $query,[],5);

        return $query;
    }






    /**
     * Creation of a new Business Partner
     *  
     *  Data comes through Post verb and must be sent by the same method 
     * 
     */
    public function createNewPartner($data)
    {

        $fullData = [
            // Checking series Prd or Test -> Prod: 146 | Test: 134
            "Series" => 146,
            "CardType" => "cCustomer",
        ];


        /**
         *  Logic: CF = 96 / RI || EX = 80
         */
        if ($data['VATCtg'] == 'CF') {

            $fullData["U_B1SYS_VATCtg"] = 'CF';
            $fullData["U_B1SYS_FiscIdType"] = 96;
        } elseif ($data['VATCtg'] == 'RI' || $data['VATCtg'] == 'EX') {

            $fullData["U_B1SYS_VATCtg"] = $data['VATCtg'];
            $fullData["U_B1SYS_FiscIdType"] = 80;
        } else {

            return false;
        }


       
        // formatting name
        if (isset($data['Name'])){
            $lastName = trim($data['LastName']);
            $name = trim($data['Name']);

            $fullName = $lastName > ''? $lastName.' '.$name : $name;
            $fullData['CardName'] = strtoupper($fullName);
        } 
 
    

        if (isset($data['FederalTaxID']) && trim($data['FederalTaxID']) > '') $fullData['FederalTaxID'] = str_replace([',', '.', ' '], '', $data['FederalTaxID']);

        if (isset($data['Phone1']) && trim($data['Phone1']) > '') $fullData['Phone1'] = str_replace([',', '.', ' ', '-'], '', $data['Phone1']);

        if (isset($data['Cellular']) && trim($data['Cellular']) > '') $fullData['Cellular'] = str_replace([',', '.', ' ', '-'], '', $data['Cellular']);

        if (isset($data['City']) && trim($data['City']) > '') $fullData['City'] = $data['City'];

        if (isset($data['Address']) && trim($data['Address']) > '') $fullData['Address'] = $data['Address'];

        if (isset($data['EmailAddress']) && trim($data['EmailAddress']) > '') $fullData['EmailAddress'] = $data['EmailAddress'];

   
        
        $query = postman::send('POST', $this->endpoint, $fullData);

        // if($query[0] !== 201){
        //     echo "<pre>";
        //     echo json_encode($fullData);
        //     echo "<br>-<br>";
        //     echo json_encode($query); 
        //     die();
        // }

        // if error on query
        if($query[0] !== 201)return false;


        // If insert is ok return card code
        return $query[1]['CardCode'];
    }
}
