<?php

namespace app\controllers\admin;

use app\classes\BruteForceProtection;
use app\classes\Csrf;
use app\classes\RequestMethodChecker;
use app\core\Components\ButtonPrimary;
use app\core\Controller;
use app\middlewares\SessionMiddleware;
use app\models\Users;
use app\requests\GuichesRequest;
use app\requests\GuichesUpdateRequest;
use app\services\GuichesService;

class GuichesController extends Controller{

    function __construct()
    {
        SessionMiddleware::handleRequest("/login");
    }

    public function index(){
        $data = [
            "pageTitle" => "Guichês - FilaFácil", 
            "view" => "admin/pages/guiches/Index",
            'title' => 'Guichês',
        ];
        $this->load("template", $data);
    }


    public function store(){
        RequestMethodChecker::check('POST', 'admin/guiches');
        // BruteForceProtection::delete();
        (new Csrf())->post();
        $validated = (new GuichesRequest)->validated();
        
        if($validated->data() && !$validated->errors()){
            BruteForceProtection::delete();
            return (new GuichesService)->create($validated->data());
        }else{
            // BruteForceProtection::check('Uma atividade não usual foi detectada do seu dispositivo.', 6, 2, 'store');
            setFlash('message', FAILED_CREATE_MESSAGE);
            $validated::setFlashMessages();
            $validated::setOld();
            back();
        }
    }

    public function update(){
        // RequestMethodChecker::check('POST', 'admin/cargos');
        // BruteForceProtection::delete();
        // (new Csrf())->post();
        $validated = (new GuichesUpdateRequest)->validated();
        
        if($validated->data() && !$validated->errors()){
            $id = $validated->data()['id']['id'];
            unset($validated->data()['id']);
            $data = $validated->data();
            $data['id'] = $id;
            $updated = (new GuichesService())->update($data,['id'],'id = :id');
            if($updated){
                echo json_encode([
                    'success' => true,
                    'message' => "Dados atualizados com sucesso!",
                ]);
                return;
            }else{
                echo json_encode([
                    'success' => false,
                    'message' => "Dados não foram atualizados!",
                ]);
                return;
            }
        }else{
            // BruteForceProtection::check('Uma atividade não usual foi detectada do seu dispositivo.', 6, 2, 'store');
            // setFlash('message', FAILED_CREATE_MESSAGE);
            $validated::setMessages();
            $response = [
                'success' => false,
                'message' => FAILED_UPDATED_MESSAGE,
            ];
            foreach($validated->errors() as $field => $methods){
                foreach($methods as $method => $message){
                    $response['errors'][] = [$field.".".$method => $message];
                }
            }
            echo json_encode($response);
            return;
            // $validated::setOld();
            // back();
        }
    }

   
    public function all(){
        // header("Content-Type: application/json");
        $request = $_REQUEST;
        $start = filter_var($request['start'], FILTER_VALIDATE_INT);
        $length = filter_var($request['length'], FILTER_VALIDATE_INT);
        $search = strip_tags($request['search']['value']);
        // dd($request);
        $colunas = [
            0 => 'id',
            1 => 'guiche',
        ]; 
        $qtd_guiches = (new GuichesService)->all()['count'];
        if(!empty(trim($search))){
            if(isset($request['order'][0]['column'])){
                $guiches = (new GuichesService)->all(['id', 'guiche'],'guiche = :search',['search' => $search, 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir']) 
                ,':start, :length');
                $qtd_guiches = $guiches['count'];
            }else{
                $guiches = (new GuichesService)->all(['id', 'guiche'],'guiche = :search',['search' => $search, 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length');
                $qtd_guiches = $guiches['count'];
            }
        }else{
            if(isset($request['order'][0]['column'])){
                $guiches = (new GuichesService)->all(['id', 'guiche'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir'])
                ,':start, :length');
            }else{
                $guiches = (new GuichesService)->all(['id', 'guiche'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length');
            }
        }

        $info_ajax = [];
        $newGuiches = [];

        foreach($guiches['data'] as $info){
            $temp = [];
            foreach($info as $key => $field){
                if($key === 'guiche'){
                    $temp[] = "Guichê " . $field;
                }else{
                    $temp[] = $field;
                }
            }
            $temp[] = (new ButtonPrimary('', 
            [
                'title' => 'Editar guichê',
                'data-bs-id' => $info->id,
                'data-bs-guiche' => $info->guiche,
                'data-bs-toggle'=>"modal",
                'data-bs-target'=>"#editarGuiche",
            ],
            'bi bi-pencil'))->render();
            $newGuiches[] = $temp;
        }
        $info_ajax = [
            "draw" => intval($request['draw']),
            "recordsTotal" => $qtd_guiches,
            "recordsFiltered" => $qtd_guiches,
            "data" => $newGuiches,
        ];
        echo json_encode($info_ajax);
        return;
    }
}