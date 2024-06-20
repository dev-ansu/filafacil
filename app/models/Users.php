<?php 

namespace app\models;
use app\core\Model2;

class Users extends Model2{

    protected $table = 'users';
    protected $fillable = ['firstname','lastname', 'user', 'password'];
    
    public function __construct(){
        $this->db();
    }
    
}