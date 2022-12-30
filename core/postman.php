<?php

namespace core;

class postman
{


    
    /**
     * send
     *
     * @param  string $method GET, POST, PATCH, ETC
     * @param  string $url
     * @param  array $data
     * @param  int $limit query limit | 0 = unlimited
     * @return array [http code, response, cookies]
     */
    public static function send(string $method, string $url, array $data = [], int $limit = 20)
    {

        $reloginAttempts = 3;

        $url = str_replace(' ', '%20', $url);

        $headers = ['Content-Type:application/json', 'Expect:']; //'Expect:' take off max size sending
        
        if($method == 'GET') array_push($headers, 'Prefer:odata.maxpagesize='.$limit);

        $sessionsaved = session::Read('sapsession');


        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYHOST => false,    // Validate SSL Certificates
            CURLOPT_SSL_VERIFYPEER => false,    // Validate SSL Certificates
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_COOKIE         => $sessionsaved,
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_CUSTOMREQUEST  => $method
        );



        // var_dump($newHeaders); die();

        $ch      = curl_init(SAPURL . $url);
        curl_setopt_array($ch, $options);
        $rough_content = curl_exec($ch);
        $header  = curl_getinfo($ch);
        // $err     = curl_errno( $ch );
        // $errmsg  = curl_error( $ch );
        curl_close($ch);

        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m";
        preg_match_all($pattern, $header_content, $matches);
        $cookiesOut = implode("; ", $matches['cookie']);

        // $header['errno']   = $err;
        // $header['errmsg']  = $errmsg;
        // $header['headers']  = $header_content;
        // $header['content'] = $body_content;
        // $header['cookies'] = $cookiesOut;


        // checking if session expired
        $error = json_decode($body_content, true);

        

        if (isset($error['error']) && $error['error']['code'] == 301) {

            // auto relogin session

            // check for user and password saved on session
            $auth = session::Read('auth');
            

            // call acmModel to re-login user
            $acmModel = new \src\models\acmModel();

            $i=0;

            while(++$i){

                // Re-login
                if ($acmModel->login($auth[0], $auth[1])) {
                    // recall
                    sleep(1);
                    return self::send($method, $url, $data, $limit);
                    break;
                } 

                if($i >=  $reloginAttempts){break;}
            }

            return false;
        }



        return [$header['http_code'], json_decode($body_content, true), $cookiesOut];
    }


    public static function getAll($request){
        $req = self::send('GET', $request,[],100);
        return $req[1]['value'];
    }
}
