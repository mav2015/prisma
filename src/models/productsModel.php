<?php namespace src\models;

use core\dbManager;
use core\postman;

class productsModel extends dbManager{

    public $message;
    private $endpoint = '/Items';
    public $division,$search,$valid=false;


    public function __construct(){
        parent::__construct();
    }

    public function getAll(){
        
        if (isset($_GET['division']) && $_GET['division'] == 'Motos') {
            return $this->getAllMotos();            
        }
       
        return $this->getAllGeneral();
    }





    public function getAllMotos(){
    
        $query = parent::listed(
            "item_code as ItemCode, item_name as ItemName, tax as ArTaxCode, year as U_ano", 
            "listaEspMotos",
            "concat(item_code,item_name,year) LIKE ?",
            [parent::search()]
        );
        

        // var_dump(parent::search()); die();

        return $query['list'];
    }



    
    /**
     * getAllGeneral
     *
     * Division needs to be specified in $this->division var
     * 
     * You can use $this->search var to make a filter 
     * 
     * ¡¡ Some others application use this feature. please don't change it !!
     * 
     * @return Object 
     */
    public function getAllGeneral(){
            // Principal query with order and filter
            $query = $this->endpoint . "?\$select=ItemCode,ItemName,ItemPrices,SalesUnit,ItemWarehouseInfoCollection,ArTaxCode&\$orderby=ItemName asc";

            $filters = [];
    
            // applying Division Filter
            if ($this->division > '') {
    
                // division First letter
                $divisionName = strtoupper($this->division[0]);
    
                // division filter on search
                array_push($filters, " U_Division eq 'D$divisionName'");
            }
    
    
            // applying Name Filter
            if ($this->search > '') {
    
                $ItemName = explode(" ", strtoupper($this->search));
    
                // Name filter on search
                array_push($filters, "contains(ItemName, '" . implode("') and contains(ItemName, '", $ItemName). "') or contains(ItemCode, '".strtoupper($this->search)."')");
            }
    


            if($this->valid){
                array_push($filters,"Valid eq 'tYES'");
            }

    
            // check if you have filters to apply
            if (count($filters) > 0) {
                $query = $query . '&$filter=' . implode(' and ', $filters);
            }
            
    
            // var_dump($query); die();
            
            $query = postman::send('GET',$query,[],20);
    
            if($query[0] == 200){

                return $query[1]['value'];
            }

            return false;
    }


   /**
     * getBrandAndModel
     *
     * @param  string $brand
     * @param  string $model
     * @return mixed (objectData | false)
     */
    public function getBrandAndModel($brand,$model){

        $brand = strtoupper($brand);
        $model = strtoupper($model);

        $url = "\$crossjoin(MARCAS,Items,MODELOS)?\$expand=MARCAS(\$select=Code,Name),MODELOS(\$select=Code,Name),Items(\$select=ItemCode,ItemName)&\$filter=(MARCAS/Code eq MODELOS/U_Marca and MARCAS/Code eq Items/U_Marca) and Items/U_Modelo eq MODELOS/Code and contains(MARCAS/Name, '$brand') and (contains(MODELOS/Name, '$model') or contains(MODELOS/Name, '".strtolower($model)."')) and (contains(Items/ItemName, '$brand') and contains(Items/ItemName, '$model'))";

        $response = postman::send('GET', $url,[],0);

        if($response[0] == 200){
            return $response[1]['value'];
        }

        return false; 
    }



}