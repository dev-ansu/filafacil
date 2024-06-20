<?php

namespace app\controllers\admin;

use app\classes\BruteForceProtection;
use app\classes\Csrf;
use app\classes\RequestMethodChecker;
use app\core\Components\ButtonPrimary;
use app\core\Controller;
use app\middlewares\SessionMiddleware;
use app\models\Users;
use app\requests\UsersRequest;
use app\services\CargosService;
use app\services\UsersService;

class UsersController extends Controller{

    function __construct()
    {
        
        SessionMiddleware::handleRequest("/login");
    }

    public function index(){
        $data = [
            "pageTitle" => "Usuários - FilaFácil", 
            "view" => "admin/pages/users/Index",
            'title' => 'Lista de usuários',
        ];
        $this->load("template", $data);
    }

    public function create(){
        $cargos = (new CargosService)->all(['id', 'cargo']);
        $data = [
            "pageTitle" => "Cadastrar usuários - FilaFácil", 
            "view" => "admin/pages/users/Create",
            'title' => 'Cadastro de usuários',
            'cargos' => $cargos['data'],
        ];
        $this->load("template", $data);
    }

    public function store(){
        RequestMethodChecker::check('POST', 'admin/users/create');
        // BruteForceProtection::delete();
        // BruteForceProtection::check('Uma atividade não usual foi detectada do seu dispositivo.', 6, 2, 'store');
        // BruteForceProtection::delete();
        (new Csrf())->post();
        $validated = (new UsersRequest)->validated();
        if($validated->data() && !$validated->errors()){
            return (new UsersService)->create($validated->data());
        }else{
            setFlash('message', FAILED_CREATE_MESSAGE);
            $validated::setFlashMessages();
            $validated::setOld();
            back();
        }
    }

   
    public function all(){
        // header("Content-Type: application/json");
        $request = $_REQUEST;
        $start = filter_var($request['start'], FILTER_VALIDATE_INT);
        $length = filter_var($request['length'], FILTER_VALIDATE_INT);
        $search = strip_tags($request['search']['value']);
        
        // if(!(new Csrf)->get()){
        //     echo json_encode([
        //         'success' => false,
        //         'message' => "CSRF Error",
        //     ]);
        //     exit;
        // }

        $colunas = [
            0 => 'id',
            1 => 'firstname',
            2 => 'lastname',
            3 => 'user',
            4 => 'cargo',
            5 => 'salario',
        ];

        $qtd_users = (new UsersService)->all()['count'];

        if(!empty(trim($search))){
            if(isset($request['order'][0]['column']) && !empty($request['order'][0]['column'])){
                $users = (new UsersService)->all(['users.id', 'firstname','lastname', 'user','c.cargo', 'c.salario'],'firstname LIKE :search OR lastname LIKE :search OR c.cargo LIKE :search OR CONVERT(c.salario, CHAR) LIKE :search OR user LIKE :search',['search' => "%".$search."%", 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir']) 
                ,':start, :length',
                'LEFT JOIN user_cargo uc ON uc.iduser = users.id
                LEFT JOIN cargos c ON uc.idcargo = c.id
                '
                );
                $qtd_users = $users['count'];
            }else{
                $users = (new UsersService)->all(['users.id', 'firstname','lastname', 'user','c.cargo', 'c.salario'],'firstname LIKE :search OR lastname LIKE :search OR c.cargo LIKE :search OR CONVERT(c.salario, CHAR) LIKE :search OR user LIKE :search',['search' => "%".$search."%", 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length',
                'LEFT JOIN user_cargo uc ON uc.iduser = users.id
                 LEFT JOIN cargos c ON uc.idcargo = c.id
                ');
                $qtd_users = $users['count'];
            }
        }else{
            if(isset($request['order'][0]['column']) && !empty($request['order'][0]['column'])){
                $users = (new UsersService)->all(['users.id', 'firstname','lastname', 'user','c.cargo', 'c.salario'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir'])
                ,':start, :length',
                'LEFT JOIN user_cargo uc ON uc.iduser = users.id
                LEFT JOIN cargos c ON uc.idcargo = c.id
                '
                );
            }else{
                $users = (new UsersService)->all(['users.id', 'firstname','lastname', 'user','c.cargo', 'c.salario'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length',
                'LEFT JOIN user_cargo uc ON uc.iduser = users.id
                LEFT JOIN cargos c ON uc.idcargo = c.id
                '    
                );            
            }
        }
        $info_ajax = [];
        $newUsers = [];

        foreach($users['data'] as $info){
            $temp = [];
            foreach($info as $key => $field){
                if($key == 'salario'){
                    $temp[] = converCurrency($field);
                }else{
                    $temp[] = $field;
                }
            }
            $temp[] = (new ButtonPrimary('', 
            [
                'title' => 'Editar usuário',
                'data-bs-id' => $info->id,
                'data-bs-firstname' => $info->firstname,
                'data-bs-lastname' => $info->lastname,
                'data-bs-user' => $info->user,
                'data-bs-salario' => $info->salario,
                'data-bs-cargo' => $info->cargo,
                'data-bs-toggle'=>"modal",
                'data-bs-target'=>"#editarUsuario",
            ],
            'bi bi-pencil'))->render();
            $newUsers[] = $temp;
        }
        // dd(count($newUsers));
        $info_ajax = [
            "draw" => intval($request['draw']),
            "recordsFiltered" => $qtd_users,
            "recordsTotal" => $qtd_users,
            "data" => $newUsers,
        ];
        echo json_encode($info_ajax);
        return;
    }
}