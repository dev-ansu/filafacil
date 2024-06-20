<?php

namespace app\core\Components;
use app\core\Components\Component;
use app\core\Components\Button;

class ButtonPrimary extends Button{

    public function __construct(string $text = '', $options = [], string $Bsicon = '', $parent = null){
        $attrClassExist = $this->verifyAttributes('class', $options);
        if(!$attrClassExist){
            $options['class'] = 'btn btn-success '; 
        }else{
            if(preg_match('/^btn(\sbtn)/', $options['class']) <= 0){
                $options['class'] = 'btn btn-success '.$options['class'];
            }
        }
 
        parent::__construct('', $options, $parent);
        $this->getElement()->textContext = '';
        if($text && $Bsicon){
            $this->bsIconPlusText($text, $Bsicon);
        }else{
            $this->element->textContent = $text;
        }
        if(!$text && $Bsicon){
            $icon = Component::$dom->createElement('i');
            $icon->setAttribute('class', $Bsicon);
            // Adicione o elemento <span> como filho do elemento <div>
            $this->element->appendChild($icon);
        }

    }
}