<?php

function setFlash($key, $message, $alert = "danger"){
    if(!isset($_SESSION["message"][$key])){
        $_SESSION["message"][$key] = [
            "message" => $message,
            "alert" => $alert
        ];
    }
}


function getFlash($key){
    if(isset($_SESSION["message"][$key])){
        $flash = $_SESSION["message"][$key];
        unset($_SESSION["message"][$key]);
        return "
        <span class='alert alert-{$flash['alert']} d-flex justify-content-between align-items-center'>
            {$flash['message']}
            <span class='btn mx-1 btn-close'></span>
        </span>
       ";
    }
}

function getFlashText($key){
    if(isset($_SESSION["message"][$key])){
        $flash = $_SESSION["message"][$key];
        unset($_SESSION["message"][$key]);
        return "{$flash['message']}";
    }
    return false;
}

function setOld($key, $value){
    if(!isset($_SESSION["old"][$key])){
        $_SESSION["old"][$key] = $value;
    }
}

function getOld($key){
    if(isset($_SESSION["old"][$key])){
        $flash = $_SESSION["old"][$key];
        unset($_SESSION["old"][$key]);
        return $flash;
    }
}
