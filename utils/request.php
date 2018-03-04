<?php

    function getResponseCurl($url,$header=""){
    
        // is curl installed?
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        
        // get curl handle
        $ch= curl_init();
    
        // set request url
        curl_setopt($ch, CURLOPT_URL, $url);
        //header 
        if($header!="")
        {
            curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        }
        //https
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        // return response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);

        $err = curl_errno($ch);
        
        curl_close($ch);
        
        return $response;
    } 

?>