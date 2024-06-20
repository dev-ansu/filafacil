<?php
namespace app\classes;

class Curl{

    protected $curl;

    public function __construct(string $method = 'POST'){
        $this->curl = curl_init();
        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ));
    }

    public function post($url, $postFields = []){
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_URL, $url);

        if(defined('API_TOKEN') && !empty(defined('API_TOKEN'))){
            $postFields['token'] = API_TOKEN;
        }
        
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $postFields);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    
    public function get($url){
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        return $this;
    }

    public function listar(){
        curl_setopt($this->curl, CURLOPT_URL, 'servidorouro/api/alunos/lista');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, 'token='.TOKEN_PRESENCIAL);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    public function sendText($sessionName, $data){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/client/sendMessage/'.$sessionName);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    public function getClassInfo($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/client/getClassInfo/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    
    public function terminateWppSession($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/terminate/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    /**
     * @param array $data - Um array contendo os seguintes parâmetros: chatId, content, options['caption' => 'legenda/mensagem']
     */

    public function sendMessageMediaFromURL($sessionName, $data = []){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/client/sendMessage/'.$sessionName);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    public function getProfilePicUrl($sessionName, $contactId){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/client/getProfilePicUrl/'.$sessionName);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode(['contactId' => $contactId]));
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    public function getSessionStatus($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/status/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

    public function getQrImageCode($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/qr/'.$sessionName."/image");
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    public function getQrCode($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/qr/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    public function terminateSession($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/terminate/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }
    public function startSession($sessionName){
        curl_setopt($this->curl, CURLOPT_URL, API_URL_BASE.'/session/start/'.$sessionName);
        curl_setopt($this->curl,  CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        $response = curl_exec($this->curl);
        curl_close($this->curl);
        return $response;
    }

}