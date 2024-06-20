<?php

namespace app\controllers\admin;

use app\classes\SessionLogin;
use app\classes\Validate;
use app\core\Controller;
use app\middlewares\SessionMiddleware;
use app\models\CalledPass;
use app\models\PreviousGeneratedPass;
use app\services\PreviousGeneratedPassService;
use app\services\UsersService;
use DateInterval;
use DateTime;
use Exception;

class HomeController extends Controller{

    function __construct()
    {
        SessionMiddleware::handleRequest("/login");
    }

    

    public function index(){
        
        $data = [
            "pageTitle" => "Página inicial - EasyQueue", 
            "view" => "admin/Index",
        ];

        $this->load("template", $data);
    }

    public function getNewPass(){
        $validate = (new Validate)->validate([
            'fetchApi' => 'optional',
        ]);
        $response = $this->getRandomPass();
        if($validate){
            echo json_encode($response);
            return;
        }
        if($response['success']){
            setFlash('message', $response['message'], 'success');
            back();
        }else{
            setFlash('message', $response['message']);
            back();
        }
    }

    private function getRandomPass(){
        $service = new PreviousGeneratedPassService;
        /* Gera a senha aleatória no formato ABC1D23 (três letras, um número, uma letra e dois números) */
        $pass = getRandomLetters(3) . getRandomNumber(1) . getRandomLetters(1) . getRandomNumber(2);
        $generated_pass = $service->one(where:'pass_generated = :pass and DATE(createdAt) = :today', data:['pass' => $pass, 'today' => today('Y-m-d')]);
        
        if(!$generated_pass){
            $user = SessionLogin::getSession()->id;
            if($user){
                $create = $service->create([
                    'pass_generated' => $pass,
                    'user' => $user,
                ]);
                if($create){
                    return ['success' => true, 'message' => 'Senha gerada com sucesso! Anote a senha: ' . $pass, 'data' => $pass];
                }else{
                    return ['success' => false, 'message' => 'A senha não foi gerada!', 'data' => null];
                }
            }else{
                return ['success' => false, 'message' => "Usuário não encontrado.", 'data' => null];
            }
        }else{
            $this->getRandomPass();
        }
        return ['success' => false, 'message' => "Houve um erro ao gerar a senha.", 'data' => null];
    }

    

    public function callNewPass(){
        $passToCall = (new PreviousGeneratedPass)->fetch(['id','pass_generated','user','createdAt','updatedAt'], ' DATE(previous_generated_pass.createdAt) = :today AND NOT EXISTS(SELECT id FROM called_pass WHERE previous_generated_pass.id = called_pass.idpass)', ['today' => today()],'','',1);

        if($passToCall){
            try{
                $guiche = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $inserted = (new CalledPass)->insert(['idpass' => $passToCall->id,'pc' => $guiche, 'iduser' => SessionLogin::getSession()->id]);
                if($inserted){
                    $_SESSION['actual_pass'] = ['pass' => $passToCall->pass_generated, 'guiche' => $guiche];
                    echo json_encode([
                        'success' => true,
                        'message' => "A senha chamada foi: $passToCall->pass_generated.",
                        'data' => $passToCall->pass_generated,
                    ]);
                    return;
                }else{
                    throw new Exception('Ocorreu um erro ao tentar chamar uma nova senha.');
                }
            }catch(\Exception $e){
                echo json_encode([
                    'success' => false,
                    'message' => "Ocorreu um erro ao tentar chamar uma nova senha. ". $e->getMessage(),
                ]);
                return;
            }      
        }else{
            unset($_SESSION['actual_pass']);
            echo json_encode([
                'success' => false,
                'message' => "Não há senhas a serem chamadas.",
            ]);
        }
    }
}