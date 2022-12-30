<?php

namespace src\models;

use core\dbManager;
use core\postman;
use core\session;

class acmModel extends dbManager
{


    /**
     *  Account Manager Model
     *  
     *  This class use some session statements:
     *      
     * # auth         ->  this session key save the username and password in plain text, to make a relogin in case of SAP session has expired    
     * # USER         ->  it have user data like username,Superuser,name,shortname,etc.
     * # sapsession   ->  SAP session used by postman class when try to make a request
     */


    public $message = null;

    public function __construct()
    {
        parent::__construct();
    }



    // // check if user still logged in
    // public function status()
    // {
    //     $auth = session::Read('auth');

    //     if (!$auth) return false;

    //     $userData = postman::send('GET', "Users?\$select=UserName&\$filter=UserCode eq '" . $auth[0] . "'");

    //     // checking if session expired
    //     if (isset($userData['error']) && $userData['error']['code'] == 301) {

    //         // Re-login
    //         if ($this->login($auth[0], $auth[1])) {
    //             return session::Read('USER');
    //         } else {
    //             // out
    //             route('acm/login', true);
    //             die();
    //         }
    //     }

    //     return session::Read('USER');
    // }





    // check if user still logged in
    public function status()
    {
        $auth = session::Read('auth');

        if (!$auth) return false;

        $userData = postman::send('GET', "Users?\$select=UserName&\$filter=UserCode eq '" . $auth[0] . "'");

        // checking if session expired
        if ($userData == false) {
            route('acm/login', true);
            die();
        }

        return session::Read('USER');
    }




    // check login and creation of session cookies
    public function login($user, $password)
    {
        
        $data = postman::send(
            'POST',
            '/Login',
            [
                "UserName" => $user,
                "Password" => $password,
                "CompanyDB" => SAPENV
            ]
        );

        $status = $data[0];
        $cookies = $data[2];


        if ($status == 200) {
            $this->message = 'Bienvenido/a';

            session::Put('sapsession', $cookies);
            session::Put('auth', [$user, $password]);

            $userData = postman::send('GET', "/Users?\$select=UserName,Superuser&\$filter=UserCode eq '" . $user . "'");

            $getUserBusinessUnit = postman::getAll("/sml.svc/YUH_UNIDADNEGOCIOUSUARIO?\$select=name,position&\$filter=USER_CODE eq '" . $user . "'");

            $businessunits = [];
            $referrer = false;

            foreach ($getUserBusinessUnit as $value){

                array_push($businessunits, $value['name']);

                if($value['position'] === 1){ 
                    $referrer = true;
                }
            } 


            $shortname = explode(' ', $userData[1]['value'][0]['UserName'])[0];

            session::Put('USER', [
                'username' => $user,
                'shortname' => $shortname,
                'name' => $userData[1]['value'][0]['UserName'],
                'Superuser' => $userData[1]['value'][0]['Superuser'],
                'BusinessUnits' => $businessunits,
                'Referrer' => $referrer
            ]);


            return $shortname;
        }

        $this->message = 'Error al intentar ingresar';
        return false;
    }



    // Logout function 
    public function logout()
    {

        session::Unset('sapsession');
        session::Unset('auth');
        session::Unset('USER');

        if (postman::send('POST', '/Logout')[0] == 200) {
            return true;
        }

        $this->message = 'Error al intentar cerrar la sesión';
        return false;
    }
}
