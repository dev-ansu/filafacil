<?php
namespace app\core\Components;

use app\core\Components\Component;

class Button extends Component{

    public function __construct(string $text = '', $options = [], $parent = null){
        $attrClassExist = $this->verifyAttributes('class', $options);
        if(!$attrClassExist){
            $options['class'] = 'btn'; 
        }else{
            if(preg_match('/^btn(\sbtn)/', $options['class']) <= 0){
                $options['class'] = 'btn '.$options['class'];
            }
        }
        parent::__construct('button', $options, $parent);
        $this->element->textContent = $text;
    }

}