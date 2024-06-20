<?php

namespace app\core;

use app\classes\SessionLogin;
use app\middlewares\PermissionMiddleware;
use app\middlewares\SessionMiddleware;
use app\models\Permissions;
use ReflectionMethod;

class Core {
    private $controller;
    private $method;
    private $params = array();
    private $folder;
    private $controllerClean;
    
    public function __construct()
    {
        $this->verifyUri();
    }
    
    private function areOptionalParams($c){
        $reflectedMethod = array_filter((new ReflectionMethod($c, $this->getMethod()))->getParameters(), fn($param)=> !$param->isOptional());
        return array_map(function($method){
            return $method->name;
        },$reflectedMethod);
    }
    
    public function run(){
        $mountedUrl = $this->mountCleanUrl();
        if(SessionLogin::has() && SessionLogin::getSession()){
            $session = SessionLogin::getSession();
            $blocked = PermissionMiddleware::check($mountedUrl, $session->idcargo);
            if($blocked){
                setFlash("message",'Você não tem permissão para acessar esta página.');
                backToPage("/admin");
                exit;
            }
        }
        $currentController = $this->getController();
        if(class_exists($currentController)){
            $c = new $currentController();
            call_user_func_array([$c, $this->getMethod()], $this->getParams());
        }else{
            echo $_ENV['NOT_FOUND_MESSAGE'];
        }
    }

    private function mountCleanUrl(){
        return implode("/", array_filter([$this->folder, $this->controllerClean, $this->getMethod()], fn($el)=> $el));
    }

    private function stripSlashesDeep($value){
        (is_array($value)) ? array_map([$this, 'stripSlashesDeep'], $value):stripslashes($value);
        return $value;
    }


    private function verifyUri(){
        
        $url = $this->getUrl();
        $urlHandled = $this->handleUrl($url);
        $url = end($urlHandled);
    
        if ($url != "") {
            
            $url = explode("/", $url);
            $url = array_values(array_filter($url, fn($v)=> $v));
            // array_shift($url);
   
            // PEGA O CONTROLLER
            if (is_dir(PASTA_PADRAO . $url[0])) {
                $this->folder = $url[0];
                if (isset($url[1]) && $url[1] != '') {
                    $this->controllerClean = $url[1];
                    $this->controller = $url[0] . "\\" . ucfirst($url[1]) . "Controller";
                    array_shift($url);
                } else {
                    $this->controllerClean = CONTROLLER_PADRAO;
                    $this->controller = $url[0]  . "\\" . ucfirst(CONTROLLER_PADRAO) . "Controller";
                }
                
            } else {
                $this->controllerClean = $url[0];
                $this->controller = ucfirst($url[0]) . "Controller";
            }
            array_shift($url);
         
            // PEGA O MÉTODO
            if (isset($url[0])) { 
                   
                if(method_exists(sprintf("%s%s", NAMESPACE_CONTROLLER, $this->controller), $url[0])){
                    $this->method = $url[0];
                    array_shift($url);
                }else{
                    SessionMiddleware::handleRequest();
                    echo "404 - MÉTODO NÃO EXISTE";
                    die;
                }
            }
        
            // PEGA OS PARÂMETROS
            if (isset($url[0])) {
                $this->params = array_filter($url);
            }
        } else {
            $this->controllerClean = CONTROLLER_PADRAO;
            $this->controller = ucfirst(CONTROLLER_PADRAO) . "Controller";
        } 
    }

    private function getUrl()
    {
        return $_SERVER['PHP_SELF'];
    }
    
    private function handleUrl(string $url = '')
    {
        if ($url) {
            $newUrl =  explode("index.php", $url);
            return $newUrl;
        }
        return $url;
    }

    private function getController()
    {
        
        $url = explode("\\", $this->controller);
    

        if (class_exists(sprintf("%s%s", NAMESPACE_CONTROLLER,  $this->controller))) {
            return sprintf("%s%s", NAMESPACE_CONTROLLER, $this->controller);
        }else{
            setFlash("message", $_ENV['NOT_FOUND_MESSAGE']);
            back();
            // return sprintf("%s%s%s%s%s", NAMESPACE_CONTROLLER, $url[0],"\\", ucfirst(CONTROLLER_PADRAO), "Controller");
        }
        
        if (isset($url[0]) && $url[0]) {
            if (is_dir(PASTA_PADRAO . $url[0])) {
                $controllerName = ucfirst(CONTROLLER_PADRAO);
            } else {
                $controllerName = ucfirst($url[0]);
            }
        }

        return sprintf("%s\\%sController", NAMESPACE_CONTROLLER, $controllerName);
    }

    private function getMethod()
    {
        $controllerClass = sprintf("%s%s", NAMESPACE_CONTROLLER, $this->controller);
      
        if (method_exists($controllerClass, $this->method)) {
            return $this->method;
        }
        
        return METODO_PADRAO;
    }

    private function getParams()
    {
        return $this->params;
    }
}

?>






