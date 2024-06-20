<?php

namespace app\classes;

use app\core\Components\Input;

class Csrf{
 
    function __construct()
    {
        if (!isset($_SESSION)) {
            session_name('CSRF_SECURITY');
            session_start();
        }
        if(Session::has('_csrf')){
            $this->deleteExpiredToken();
        }else{
            $_SESSION['_csrf'] = [];
        }
    }
    
    public function deleteExpiredToken(){
        if(isset($_SESSION['_csrf'])){
            if(isset($_SESSION['_csrf']['tokens'])){
                foreach($_SESSION['_csrf']['tokens'] as $key => $token){
                    if($token['time'] <= time()){
                        unset($_SESSION['_csrf']);
                    }
                }
            }
        }
        // if(isset($_SESSION['_csrf']['time']) && $_SESSION['_csrf']['time'] <= time()) unset($_SESSION['_csrf']);
    }

    public function set($time = true){
        $time = time() + (($time ? 1:$time) * 3600);
        $token = null;
        if(function_exists('openssl_random_pseudo_bytes')){
            $token = substr(bin2hex(openssl_random_pseudo_bytes(128)), 0,128);
        }else{
            $token = sha1(mt_rand() . rand());
        }

        $_SESSION['_csrf']['tokens'][] = ['token' => $token, 'time' => $time];

        // $_SESSION['_csrf']['token'] = $token;
        // $_SESSION['_csrf']['time'] = $time;
        return $token;
    }

    public function Csrf($parent = null){
        $token = $this->set();
        return new Input('hidden', '_csrf', ['value' => $token], $parent);
    }

    public function getCSRF(){
        return $this->set();
    }

    public function get($name = "_csrf"){
        if(isset($_GET[$name])) return $this->check($_GET[$name]);
        if(isset($_GET['fetchApi']) && (strip_tags($_GET['fetchApi'] == 'true' || strip_tags($_GET['fetchApi']) == true))){
            echo json_encode([
                'success' => false,
                'message' => 'CSRF Error',
            ]);
            exit;
        }else{
            setFlash('message','CSRF Error');
            back();
        }
    }

    public function post($name = "_csrf"){
        // dd($_GET['salario']);
        if(isset($_POST[$name])) return $this->check($_POST[$name]);
        if(isset($_POST['fetchApi']) && (strip_tags($_POST['fetchApi'] == 'true' || strip_tags($_POST['fetchApi']) == true))){
            echo json_encode([
                'success' => false,
                'message' => 'CSRF Error',
            ]);
            exit;
        }else{
            setFlash('message','CSRF Error');
            back();
        }
    }

    private function check($token){
        $this->deleteExpiredToken();
        
        if(isset($_SESSION['_csrf']['tokens']) && in_array($token, array_column($_SESSION['_csrf']['tokens'], 'token'))){
            unset($_SESSION['_csrf']);
            return $token;
        }

        return false;
    }


}