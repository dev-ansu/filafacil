<?php


namespace app\classes;
use app\classes\Curl;

class ApiZap{

    public function sendText($sessionName, $data){
        $curl = new Curl();
        $send = $curl->sendText($sessionName, $data);
        return json_decode($send, true);
    }

    public function terminateWppSession($sessionName){
        $curl = new Curl('GET');
        $send = $curl->terminateWppSession($sessionName);
        return json_decode($send, true);
    }

    public function getSessionStatus($sessionName){
        $curl = new Curl('GET');
        $send = $curl->getSessionStatus($sessionName);
        return json_decode($send, true);
    }

    public function getQrImageCode($sessionName){
        $curl = new Curl('GET');
        $send = $curl->getQrImageCode($sessionName);
        return $send;
    }

    public function getMyProfilePicUrl($sessionName){
        $curl = new Curl('GET');
        $send = $curl->getClassInfo($sessionName);
        return json_decode($send, true);
    }

    public function sendMessageMediaFromURL($sessionName, $data){
        $curl = new Curl();
        $send = $curl->sendMessageMediaFromURL($sessionName, $data);
        return json_decode($send, true);
    }

    public function getProfilePicUrl($sessionName, $contactId){
        $curl = new Curl();
        $send = $curl->getProfilePicUrl($sessionName, $contactId);
        return json_decode($send, true);
    }

    public function getClassInfo($sessionName){
        $curl = new Curl('GET');
        $send = $curl->getClassInfo($sessionName);
        return json_decode($send, true);
    }

    public function getQrCode($sessionName){
        $curl = new Curl('GET');
        $send = $curl->getQrCode($sessionName);
        return json_decode($send, true);
    }

    public function startSession($sessionName){
        $curl = new Curl('GET');
        $send = $curl->startSession($sessionName);
        return json_decode($send, true);
    }
    
    public function terminateSession($sessionName){
        $curl = new Curl('GET');
        $send = $curl->terminateSession($sessionName);
        return json_decode($send, true);
    }
}