<?php
namespace app\middlewares;
use app\classes\SessionLogin;

class SessionMiddleware extends SessionLogin{
    
    public static function handleRequest(string $to = ''){
        session_regenerate_id();
        $token = self::getAndCryptAgentUserAndAddr();
        $logged = self::has(SESSION_LOGIN);
        switch ($logged){
            case false:
                session_regenerate_id();
                session_destroy();
                redirectToLogin();
                break;
            case true:
                if($_SESSION[SESSION_OWNER_LOGIN] != $token){
                    session_regenerate_id();
                    session_destroy();
                    redirectToLogin();
                    return false;
                }else{
                    return true;
                }
                break;
            default:
                return false;
            break;
        }
    }

}