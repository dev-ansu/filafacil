<?php
namespace app\controllers;

use app\classes\BruteForceProtection;
use app\classes\Csrf;
use app\classes\SessionLogin;
use app\core\Controller;
use app\models\Permissions;
use app\models\UserCargo;
use app\requests\LoginRequest;
use app\services\UserCargoService;
use app\services\UsersService;

class LoginController extends Controller{

    protected $csrf;

    function __construct(){
        $this->csrf = new Csrf();
    }

    public function index(){
        $data = [
            "pageTitle" => "Acesso restrito", 
            "view" => "Login",
        ];

        $this->load("templatelogin", $data);
    }


    public function auth(){
        
        $this->csrf->post();
        
        // BruteForceProtection::check('Muitas tentativas de login foram detectadas.',5,1,'auth');
        $validated = (new LoginRequest())->validated();

        if($validated->errors()){
            $validated::setFlashMessages();
            back();
        }
        
        extract($validated->data());
        
        $passed = password_verify($password, $user['data']->password) ?? false;
        
        switch ($passed){
            case true:
                $data = (new UsersService)->one(['users.id','firstname','lastname','uc.idcargo','c.cargo','GROUP_CONCAT(permission_name) AS permissions'],
                'users.user = :user', 
                ['user' => $user['data']->user],'','','',
                'LEFT JOIN user_cargo uc ON uc.iduser = users.id
                 LEFT JOIN cargos c ON c.id = uc.idcargo
                 LEFT JOIN permissao_bloqueada pb ON pb.idcargo = uc.idcargo
                 LEFT JOIN permissions p ON p.id = pb.idpermission
                '
                );
                // dd($data);
                $data->permissions = explode(",", $data->permissions);
                BruteForceProtection::delete();
                setFlash('message', 'Usuário logado com sucesso!', 'success');
                SessionLogin::setLoginSession($data);
                redirect('admin');
                break;
            default:
                BruteForceProtection::check('Muitas tentativas de login foram detectadas.',5,1,'auth');
                setFlash('message', 'Usuário não encontrado com as informações passadas. Tente novamente!');
                back();
                break;
        }
            
    }

    public function logout(){
        $session = SessionLogin::removeLoginSession();
        if($session){
            redirect('login');
        }
    }

}