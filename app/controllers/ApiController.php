<?php

namespace app\controllers;

use app\classes\Csrf;
use app\classes\Curl;
use app\classes\Validate;
use app\core\Controller;
use app\models\CalledPass;
use app\models\PreviousGeneratedPass;
use app\models\Users;
use app\requests\PaginateRequest;
use app\services\UsersService;

class ApiController extends Controller{

    protected $curl;

    public function __construct()
    {
        // header('Content-Type: application/json');
        $this->curl = new Curl();    
    }
    public function index(){}
    
    public function getAverageWaitTime(){
        $headers = getallheaders();
               
        $previousGenerated = (new PreviousGeneratedPass('pgp, called_pass cp'))->fetch(['count(pgp.id) QtdPass', '
        SUM(TIMEDIFF(cp.createdAt, pgp.createdAt)) / COUNT(pgp.id) AS TimeDiff'],'cp.idpass = pgp.id and (DATE(pgp.createdAt) = :today AND DATE(cp.createdAt) = :today)', ['today' => today()]);
        $formated = gmdate('H:i:s', 0);
        
        if(isset($previousGenerated->QtdPass) && $previousGenerated->QtdPass > 0){
            $formated = gmdate('H:i:s', $previousGenerated->TimeDiff);
        }

        if(isset($headers['fetchApi']) && $headers['fetchApi'] == 'true'){
            echo json_encode([
                'success' => true,
                'data' => $formated,
            ]);
            return;
        }else{
            dd($formated);
        }
        return $formated;
    }

    public function sendPassToFront(){
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $pass = (new CalledPass('cp'))->fetch(['pgp.pass_generated as pass, cp.pc as guiche'],'date(cp.createdAt) = :today and date(pgp.createdAt) = :today',['today' => today()], join:"
        JOIN previous_generated_pass pgp ON cp.idpass = pgp.id
        ",groupBy:'cp.id DESC');
        $this->setResponse($pass);
    }

    private function setResponse($message){
        $pass = $message->pass;
        $guiche = $message->guiche;
        $data = json_encode(['pass' => $pass, 'guiche' => $guiche]);
        echo "Event: message\n\n";
        echo "data: $data";
        echo "\n\n";
    }

    public function getUser(){
        $user = (new Validate)->validate(['user' => "required|existe:users"]);
        
        if(!$user){
            echo json_encode([
                'success' => false,
                'message' => 'Este usuário não existe.'
            ]);
            return;
        }
        echo json_encode([
            'success' => true,
            'message' => 'Este usuário existe.'
        ]);
        return;
    }
    public function getAllPreviousCalled(){
        $all = (new CalledPass)->fetchAll(['idpass, iduser, pc, pgp.pass_generated'],'DATE(called_pass.createdAt) = :today',['today' => today()],'','called_pass.createdAt DESC', join:'
        LEFT JOIN previous_generated_pass pgp ON pgp.id = called_pass.idpass
        ');
        echo json_encode([
            'data' => $all['data'],
        ]);
        return;
    }
    public function csrf(){
        $csrf = (new Csrf)->getCSRF();
        echo json_encode($csrf);
        return;
    }
    
    public function all()
    {
        $url = API_URL . "/api/alunos/lista";
        $response = $this->curl->post($url);
        // echo $response;
        return $response;
    }

    public function paginate(){

        $validate = (new PaginateRequest)->validated();
        $inicio = 0;
        $max = 10;
        $data = $validate->data();

        $users = json_decode($this->all(), true);

        if(trim($data['search'])){
            $users = array_filter(array_map(function($user) use($data){
                if(str_contains($user['nome'], $data['search']) || str_contains($user['usuario'], $data['search'])){
                    return $user;
                }
            }, $users), fn($user)=> $user); 
        }

        $maxPages = ceil(count($users) / $max);
       
        if($data){
            if($data['page'] < 2 || is_nan($data['page']) || $data['page'] > $maxPages){
                $data['page'] = 1;
            }else{
                $inicio = (intval($data['page']) * $max) - $max;
            }
        }   

        $users = array_slice($users, $inicio, $max);
        echo json_encode($users);
        return;   
    }

}