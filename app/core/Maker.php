<?php

namespace app\core;

define("CONTROLLER_PATH", "app/controllers/");
define("REQUESTS_PATH", "app/requests/");
define("MODELS_PATH", "app/models/");

class Maker{

    private $path;
    private $namespace;
    private $name;
    private $file;
    private $content;

    public function __construct($command, $argument){

        $function = "make" . ucfirst($command);

        if(method_exists($this, $function)){
            call_user_func([$this, $function], $argument);
        }else{
            echo "Comando '{$command}' nao foi reconhecido.\n";
            exit(1);
        }
    }
    
    private function makeDir($name_controller){
        $exploded = explode("/", $name_controller);
        $controller = $exploded[count($exploded) - 1];
        unset($exploded[count($exploded) - 1]);

        $dir = $this->path .  implode("/", $exploded);

        if(!is_dir($dir)){
            if (!mkdir($dir, 0777, true)) {
                echo "Erro ao criar a pasta!";
                exit(1);
            }
            echo "A pasta foi criada com sucesso! \n";
            $this->namespace =  str_replace("/", "\\", $dir);
            $this->name = ucfirst($controller);
            $this->file = $dir . "/" . ucfirst($controller) . ".php"; 
            return true;     
        }

        $this->namespace =  str_replace("/", "\\", $dir);
        $this->name = ucfirst($controller);
        $this->file = $dir . "/" . ucfirst($controller) . ".php"; 
        return true;
    }

    
    private function make(){
        if(file_put_contents($this->file, $this->content) !== false){
            echo "O arquivo foi criado com sucesso!";
        }else{
            echo "O arquivo não foi criado!";
        }
    }

    private function fileWithDir($argument){
        $this->makeDir($argument, $this->path);
        // call_user_func_array([$this, $this->actualMethod], [$nam]);
    }

    private function onlyFile($argument){
        $this->name = ucfirst($argument);
        $namespace = str_replace("/", "\\", $this->path);
        $this->namespace = rtrim($namespace, "\\");
        $this->file = $this->path . $this->name . ".php";
    }

    private function makeController($argument){
        $this->path = CONTROLLER_PATH;
        
        if(!strpos($argument, "Controller")){
            $argument = $argument . "Controller";
        }
        
        if(!strpos($argument, "/")){
            $this->onlyFile($argument);
        }else{
            $this->fileWithDir($argument);
        }

        if(file_exists($this->file)){
            echo "O controller '{$this->name}' já existe. \n";
            exit(1);
        }
        $this->content = <<<PHP
<?php

namespace {$this->namespace};
use app\middlewares\SessionMiddleware;
use app\core\Controller;

class {$this->name} extends Controller{

    public function index(){

    }

}
PHP;
        $this->make();   
    }
    
 
    private function makeRequest($argument){
        $this->path = REQUESTS_PATH;
        
        if(!strpos($argument, "Request")){
            $argument = $argument . "Request";
        }

        if(!strpos($argument, "/")){
            $this->onlyFile($argument);
        }else{
            $this->fileWithDir($argument);
        }

        if(file_exists($this->file)){
            echo "O request '{$this->name}' já existe. \n";
            exit(1);
        }
        $this->content = <<<PHP
<?php

namespace {$this->namespace};
use app\\requests\\Request;

class {$this->name} extends Request{

    public function __construct(){
        parent::__construct(\$this);
    }

    public function authorize(){
        return true;
    }

    public function rules():array{
        return [];
    }

    public function messages():array{
        return [];
    }

}
PHP;
        $this->make();
        
    }

    private function makeModel($argument){
        $this->path = MODELS_PATH;
        
        if(!strpos($argument, "Model")){
            $argument = $argument . "Model";
        }

        if(!strpos($argument, "/")){
            $this->onlyFile($argument);
        }else{
            $this->fileWithDir($argument);
        }

        if(file_exists($this->file)){
            echo "O request '{$this->name}' já existe. \n";
            exit(1);
        }
        $this->content = <<<PHP
<?php 

namespace {$this->namespace};
use app\core\Model2;

class {$this->name} extends Model2{

    protected \$table = '';
    protected \$fillable = [];
    
    public function __construct(\$alias = ''){
        if(trim(\$alias)){
            \$this->table.= " \$alias";
        }
        \$this->db();
    }
    
}
PHP;
        $this->make();
        
    }
}