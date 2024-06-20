<?php
namespace app\core\Components;

use app\core\Components\LinkNavigation;

class DeleteLink extends LinkNavigation{

    public function __construct(string $href = '', $options = [], $parent = null){
        parent::__construct($href, $options, $parent);
        $attrClassExist = $this->verifyAttributes('class', $options);
        if(!$attrClassExist){
            $options['class'] = 'btn btn-danger '; 
        }else{
            if(preg_match('/^btn(\sbtn)/', $options['class']) <= 0){
                $options['class'] = 'btn btn-danger '.$options['class'];
            }
        }
        $this->element->setAttribute('title', 'Excluir registro');
        $this->bsIconPlusText('Excluir', 'bi bi-x-lg');
    }

}