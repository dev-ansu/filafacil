<?php

namespace app\classes;

/**
 * Faz o upload de uma imagem
 */
class ImageUploader extends FileUploader{

      /**
     * @param array $file - é o arquivo a ser processado, passado pela variável global $_FILE[];
     * @param array $fileTypes - um array de tipos de arquivos
     * @param int|float $acceptedSize - um tamanho em Megabytes aceitável para o arquivo
     * @return bool
     */
    public function __construct(array $file, array $fileTypes, $acceptedSize){
        parent::__construct($file, $fileTypes, $acceptedSize);
    }

    /**
     * Retorna o nome do arquivo único gerado
     */
    public function getImageName(){
        return $this->fileName . "." . $this->ext;
    }

    /**
     * Retorna o tamanho do arquivo em bytes
     */
    public function getFileSize(){
        return $this->fileSize . "b";
    }

    /**
     * Realiza o upload da imagem usando o método protegido upload() da classe Pai
     */
    public function uploadImage(){
        if($this->validateExtensionAndSizeOfFile()){
            return $this->upload();                
        }else{
            $exts = implode(', ',$this->fileTypes);
            return $this->errorResponse(
                "A extensão do arquivo pode ser dos seguintes tipos: ({$exts}). O tamanho de ({$this->acceptedSize}b). "
            );
        }
    }
}