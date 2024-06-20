<?php

namespace app\controllers\admin;

use app\classes\BruteForceProtection;
use app\classes\Csrf;
use app\classes\RequestMethodChecker;
use app\core\Components\ButtonPrimary;
use app\core\Controller;
use app\middlewares\SessionMiddleware;
use app\requests\CargosRequest;
use app\requests\CargosUpdateRequest;
use app\services\CargosService;

class CargosController extends Controller{

    function __construct()
    {
        SessionMiddleware::handleRequest("/login");
    }

    public function index(){
        $data = [
            "pageTitle" => "Cargos - FilaFácil", 
            "view" => "admin/pages/cargos/Index",
            'title' => 'Cargos',
        ];
        $this->load("template", $data);
    }


    public function store(){
        RequestMethodChecker::check('POST', 'admin/cargos');
        // BruteForceProtection::delete();
        (new Csrf())->post();
        $validated = (new CargosRequest)->validated();
        
        if($validated->data() && !$validated->errors()){
            BruteForceProtection::delete();
            return (new CargosService)->create($validated->data());
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
        (new Csrf())->post();
        $validated = (new CargosUpdateRequest)->validated();
        
        if($validated->data() && !$validated->errors()){
            $id = $validated->data()['id']['id'];
            unset($validated->data()['id']);
            $data = $validated->data();
            $data['id'] = $id;
            $updated = (new CargosService)->update($data,['id'],'id = :id');
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
            ];
            foreach($validated->errors() as $field => $methods){
                foreach($methods as $method => $message){
                    $response[] = [$field.".".$method => $message];
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
            1 => 'cargo',
            2 => 'salario',
        ]; 
        $qtd_cargos = (new CargosService)->all()['count'];
        if(!empty(trim($search))){
            if(isset($request['order'][0]['column'])){
                $cargos = (new CargosService)->all(['id', 'cargo', 'salario'],'cargo LIKE :search OR CONVERT(salario, CHAR) LIKE :search',['search' => "%".$search."%", 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir']) 
                ,':start, :length');
                $qtd_cargos = $cargos['count'];
            }else{
                $cargos = (new CargosService)->all(['id', 'cargo', 'salario'],'cargo LIKE :search OR CONVERT(salario, CHAR) LIKE :search',['search' => "%".$search."%", 'start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length');
                $qtd_cargos = $cargos['count'];
            }
        }else{
            if(isset($request['order'][0]['column'])){
                $cargos = (new CargosService)->all(['id', 'cargo', 'salario'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'',
                $colunas[intval($request['order'][0]['column'])] ." " . strip_tags($request['order'][0]['dir'])
                ,':start, :length');
            }else{
                $cargos = (new CargosService)->all(['id', 'cargo', 'salario'],'',['start,\PDO::PARAM_INT' => $start, 'length,\PDO::PARAM_INT' => $length],'','',':start, :length');
            }
        }

        $info_ajax = [];
        $newcargos = [];

        foreach($cargos['data'] as $info){
            $temp = [];
            foreach($info as $key => $field){
                if($key === 'salario'){
                    $temp[] = converCurrency($field);
                }else{
                    $temp[] = $field;
                }
            }
            $temp[] = (new ButtonPrimary('', 
            [
                'title' => 'Editar cargo',
                'data-bs-idcargo' => $info->id,
                'data-bs-cargo' => $info->cargo,
                'data-bs-salario' => $info->salario,
                'data-bs-toggle'=>"modal",
                'data-bs-target'=>"#editarCargo",
            ],
            'bi bi-pencil'))->render();
            $newcargos[] = $temp;
        }
        $info_ajax = [
            "draw" => intval($request['draw']),
            "recordsTotal" => $qtd_cargos,
            "recordsFiltered" => $qtd_cargos,
            "data" => $newcargos,
        ];
        echo json_encode($info_ajax);
        return;
    }
}