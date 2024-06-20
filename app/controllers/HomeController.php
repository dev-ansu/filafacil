<?php

namespace app\controllers;

use app\core\Controller;
use app\middlewares\SessionMiddleware;

class HomeController extends Controller{

    // function __construct()
    // {
    //     SessionMiddleware::handleRequest("/login");
    // }

    // Página inicial do sistema EasyQueue
    public function index(){
        
        $data = [
            "pageTitle" => "Página inicial - EasyQueue", 
            "view" => "Index",
            'actualPass' => 54564,
        ];

        $this->load("templatehome", $data);
    }

}