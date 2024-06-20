<?php

namespace app\core;

use app\classes\Csrf;
use app\interfaces\ControllerInterface;
use app\classes\SessionLogin;


abstract class Controller implements ControllerInterface{
    
    protected function load($viewName, $viewData=array()){  
        $csrf = new Csrf();

        $viewData['csrf'] = $csrf;

        if(SessionLogin::has()){
            $viewData['session'] = SessionLogin::getSession();
        }
        extract($viewData);
        include "app/views/{$viewName}".".php";
   }

}
