<?php

namespace app\core\Components;
use DOMDocument;

spl_autoload_register(function($class_name){
    $path = __DIR__;
    $files = array_filter(scandir($path), fn($file)=> str_contains($file, ".php"));
    foreach($files as $file){
        if(is_file($path . "\\" . $file)){
            if(strpos($file, $class_name) !== false){
                include $path . "\\" . $file;
            }
        }
    }
});


/**
 * Classe para criação de componentes
 * 
 */
class Component{

    // Atributos e métodos da classe
    protected $element;
    protected $tag;
    protected $options;
    protected $parent;
    protected static $dom;
    
    /**
     * Método construtor da classe
     * @param string $tag - a tag do elemento a ser criado
     * @param array $options - os atributos do elemento a ser criado
     * @param $parent - o elemento pai a qual o elemento a ser criado pertence
     * @return void
     */
    public function __construct(string $tag, array $options = [], $parent = null){
       
        // Verifica se o documento DOM já foi criado
        if (!isset(Component::$dom)) {
            Component::$dom = new DOMDocument();
        }
        // Atribui os valores passados no método construtor aos atributos
        $this->tag = $tag;
        $this->options = $options;
        $this->parent = $parent;
        $this->build();
    }
    
    /**
     * Método público que constrói o elemento
     * @return $this
     */
    public function build(){

     $this->element = Component::$dom->createElement($this->tag);
        if($this->options){
            foreach($this->options as $key => $value){
                if($key == "textContent"){
                    $this->element->$key = $value;
                }else{
                    $this->element->setAttribute($key, $value);
                }
            }
        }
        // Verifica se o elemento é uma instância de Component
        if ($this->parent instanceof Component){
            // Verifica se os elementos pertencem ao mesmo documento
            if($this->element->ownerDocument !== $this->parent->getDocument()){
                // Importa o nó do elemento filho para o documento do elemento pai
                $importedChild = $this->parent->getDocument()->importNode($this->element, true);
                $this->parent->getElement()->appendChild($importedChild);
            }else{
                $this->parent->getElement()->appendChild($this->element);
            }
        }
        return $this;
    }

    protected function bsIconPlusText($text, $bsIcon){
        $textC = Component::$dom->createElement('div');
        $icon = Component::$dom->createElement('i');
        
        $icon->setAttribute('class', $bsIcon);
        // Adicione o elemento <span> como filho do elemento <div>
    
        $textC->setAttribute('class', 'd-flex flex-column-reverse justify-content-center align-items-center');
        $textC->setAttribute('style', 'font-size:11px');
        $textC->textContent = $text;
        $textC->appendChild($icon);
        $this->element->appendChild($textC);
    }
    
    /**
     * Inclui um filho ao elemento
     * @param $child - o elemento filho
     */
    public function appendChild($child) {

        // Verifica se o filho é uma instância de Component
        if ($child instanceof Component) {
            // Verifica se os elementos pertencem ao mesmo documento
            if($this->element->ownerDocument !== $child->getElement()->ownerDocument){
                $importedChild = $this->element->ownerDocument->importNode($child->getElement(), true);
                $this->element->appendChild($importedChild);
            }else{
                $this->element->appendChild($child->getElement());
            }
        }
    }

    public function getDocument() {
        return Component::$dom;
    }

    public function getElement() {
        return $this->element;
    }

    public function render() {
        // Retorna o HTML do elemento e de todos os seus filhos
        return Component::$dom->saveHTML($this->element);
    }

    protected function verifyAttributes($attr, $options){
        if(in_array($attr, array_keys($options))){
            return true;
        }
        return false;
    }
    
}