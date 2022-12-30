<?php namespace core\console_src;

class console_templates{
    use console_paths;

    public static $i;

    public static function st(){
    
        if(self::$i instanceof self){
            return self::$i;
        }
        self::$i = new self;
    
        return self::$i;
    }

    public static function dbConfig(){
        $text = '<?php namespace config;
/** 
 * Data Base configuration
 * ---> when setting the host: don\'t use "localhost" instead use "127.0.0.1"
 *
 * If you have problems with PDO you should install the driver
 * sudo apt install php7.4-mysql OR sudo apt install php-mysql 
 */
 
class dbConfig{
    protected $config_host="127.0.0.1",
    $config_db="softwaredb",
    $config_user="root",
    $config_password="",
    $config_prefix="mydb_",
    $config_pagination=10;
}';
    return $text;
    }






    
    public static function env(){

    $text = '<?php
/**
 * ¡¡ Environment Configuration !!
 */
define("DEBUG",true);

/**
 * Site URL 
 * example: "https://myhost/myproject"
 * 
 * ----> dynamic URL: define("URL", "http://". $_SERVER["HTTP_HOST"] ."/software");
 */
define("URL","http://".$_SERVER["HTTP_HOST"]."/real-software");
define("APIURL","http://".$_SERVER["HTTP_HOST"]."/real-software");

// SAP url 
define("SAPURL","https://190.2.251.208:50000/b1s/v1");
// SAP environment : YUHMAKSA_TEST | YUHMAKSA_PRD
define("SAPENV","YUHMAKSA_TEST");


/**
 * General configurations
 */
define("GENERAL",[
    "sitelang"=>"es_ES",
    "sitename"=>"Real Software",
    "sitedescription"=>"Micro framework",
    "sitekeywords"=>"framework micro microframework",
    "version"=>"u1.0.0",
    "supportEmail"=>"support@real-software"
]);

/**
 * TimeZone configuration
 */
date_default_timezone_set("America/Argentina/Tucuman");

';

        return $text;
    }




    
    

   public static function hostauth(){
        $text = '{
    "allow":false,
    "host":"127.0.0.1",
    "port":8000,
    "user":"MyUser",
    "pass":"MyPass",
    "endFolder":"/home/u154321_my_user/public_html/"
}';


        return $text;
    }    








    public static function controller($module=''){

        /**
        * Controller content
        */
    $text = "<?php\n
use core\\render;

final class {$module}Controller{

    public function index(){
        render::view('{$module}/index.php',['controllerName'=>'{$module}']);
    }
}";


            return $text;
    }
    
    








    public static function apiController($module=''){

        /**
        * apiController content
        */
    $text = "<?php\n
use core\\render;
use core\\controller;

final class {$module}Controller extends controller{

    public function index(){
        render::json()->message('{$module}')->out();
    }
}";


            return $text;
    }










    
    public static function model($module=''){


    /**
    * Model content
    */
    $modelNameSpace = self::st()->nspace('modelFolder');

    $text = "<?php namespace {$modelNameSpace};\n
use core\dbManager;

class {$module}Model extends dbManager{
".'
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

}';
    
    
        return $text;
    }












    public static function view($module=''){

/**
* view content
*/
    $text = '<?=self::html()?>

<?=self::body()?>

<div class="padd1">

    <div class="centered-column padd4">
        <h2> <?=$controllerName?> </h2>
        <img src="<?= asset(\'img/icons/tool.svg\') ?>" width="50px">
    </div>
</div>

<?=self::end()?>';
    
        return $text;
    }



















    public static function database($table,$prefix){

    /**
    * database structure
    */
    $text = '<?php namespace database;

use core\dbCrafter;

class '.$prefix.$table.'{

    private $crafter;
    
    public function __construct()
    {        
        $this->crafter = new dbCrafter("'.$table.'");
    }
    

    public function install(){
        $this->crafter->craft(function($column){
            $column->id();
            $column->trace();
        });
    }



    public function uninstall(){
        $this->crafter->uncraft();
    }
        
        

}';
    
    
        return $text;
    }

















    public static function htaccess(){
        $text = [
            "RewriteEngine On",
            "RewriteBase /".basename(dirname(__FILE__,3))."/",
            "RewriteCond %{THE_REQUEST} /public/([^\s?]*) [NC]",
            "RewriteRule ^ %1 [L,NE,R=302]",
            "RewriteRule ^((?!public/)(.+)\.(.+))$ public/$1 [L,NC]",
            "RewriteRule ^((?!public/)(.*))$ public/index.php?url=$1 [L,QSA]"
        ];

        return $text;
    }













    public static function default404(){
        $text='<?php
    http_response_code(404);
    self::html(["title"=>"Error 404 Página no encontrada"]);
?>

<?=self::body()?>

<div class="centered-column padd4">
    <img src="<?= asset(\'img/icons/tool.svg\') ?>" width="30px">
    <h4>ERROR 404. No se encontró la página.</h4> 
    <a href="<?=route()?>" title="Volver a la página principal">Pág. principal</a>
</div>

<?=self::end()?>';

        return $text;
    }







    public static function defaultdeny(){
        $text='<?php
    http_response_code(403);
    self::html(["title"=>"Error 403 acceso restringido"]);
?>

<?=self::body()?>

<div class="centered-column padd4">
    <img src="<?= asset(\'img/icons/tool.svg\') ?>" width="30px">
    <h4>Permiso denegado.</h4> 
    <a href="<?=route()?>" title="Volver a la página principal">Pág. principal</a>
</div>

<?=self::end()?>';

        return $text;
    }
}
