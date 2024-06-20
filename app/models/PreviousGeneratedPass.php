<?php 

namespace app\models;
use app\core\Model2;

class PreviousGeneratedPass extends Model2{

    protected $table = 'previous_generated_pass';
    protected $fillable = ['pass_generated','user'];
    
    public function __construct($alias = ''){
        if(trim($alias)){
            $this->table.= " $alias";
        }
        $this->db();
    }
    
}