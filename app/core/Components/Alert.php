<?php
namespace app\core\Components;

use app\core\Components\Component;

class Alert extends Component{

    public function __construct(string $alertType = 'danger',string $message = 'Alert', $parent = null){
        parent::__construct('div', ['textContent' => $message, 'class' => "alert alert-{$alertType} d-flex justify-content-between align-items-center"], $parent);
        // Crie o elemento <span> dentro do construtor da classe Alert
        $closeButton = Component::$dom->createElement('span');
        // $closeButton->textContent = 'X';
        $closeButton->setAttribute('class', 'btn mx-1 btn-close');

        // Adicione o elemento <span> como filho do elemento <div>
        $this->element->appendChild($closeButton);
    }

}