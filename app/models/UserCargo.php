<?php 

namespace app\models;
use app\core\Model2;

class UserCargo extends Model2{

    protected $table = 'user_cargo';
    protected $fillable = ['iduser', 'idcargo'];
    
    public function __construct(){
        $this->db();
    }
    
}