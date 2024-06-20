<?php

namespace app\core\Components;
use app\core\Components\Component;

class Form extends Component{
    protected $method;
    protected $action;

    public function __construct($method = 'post', $action = '', $options = [], $parent = null) {
        parent::__construct('form', $options, $parent);
        $this->method = $method;
        $this->action = $action;
        $this->element->setAttribute('method', $method);
        $this->element->setAttribute('action', $action);
    }

    public function addFormGroup(){
        $formGroup = new Component('div', ['class' => 'form-group'], $this);
        $this->appendChild($formGroup);
        return $formGroup;
    }

    public function addLabel($name, $labelText, $parent = null){
        $label = new Label($name, ['textContent' => $labelText]);
        if(!$parent){
            $this->appendChild($label);
        }else{
            $parent->appendChild($label);
        }
    }

    public function addButtonSubmit($text = 'CADASTRAR'){
        $button = new ButtonPrimary($text);
        $this->appendChild($button);
    }

    public function addInputField($type = 'text', $name, $options = [], $parent = null){
        $input = new Input($type, $name, $options);
        if(!$parent){
            $this->appendChild($input);
        }else{
            $parent->appendChild($input);
        }
    }
}