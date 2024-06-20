<?php 

namespace app\models;
use app\core\Model2;

class Cargos extends Model2{

    protected $table = 'cargos';
    protected $fillable = ['cargo', 'salario'];
    
    public function __construct(){
        $this->db();
    }
    
}