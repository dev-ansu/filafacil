<?php

namespace app\classes;

/**
 * Classe pai que faz upload de arquivos
 */
abstract class FileUploader{

    
    protected array $fileTypes;
    protected int $acceptedSize;
    protected int $kb;
    protected string $fileName;
    protected float $fileSize;
    protected string $ext;
    protected array $file;
    
    /**
     * @param array $file - é o arquivo a ser processado, passado pela variável global $_FILE[];
     * @param array $fileTypes - um array de tipos de arquivos
     * @param int|float $acceptedSize - um tamanho em Megabytes aceitável para o arquivo
     * @return bool
     */

    public function __construct(array $file, array $fileTypes, int $acceptedSize){
        $this->fileTypes = $fileTypes;
        $this->kb = 1024;
        $this->acceptedSize = ceil($acceptedSize * $this->kb);
        if(!$file || $file['error'] !== UPLOAD_ERR_OK){
            return $this->errorResponse('Falha no envio do arquivo!');
        }
        $this->file = $file;
        $this->extractFileInfo();
    }

    /**
     * Extrai as informações do arquivo a ser processado e gera um novo nome para o arquivo
     */
    protected function extractFileInfo(){
        $oldName = $this->file['name'];
        $this->fileName = $this->generateFileName($oldName);
        $this->ext = pathinfo($oldName, PATHINFO_EXTENSION);
        $this->fileSize = ceil($this->file['size'] / $this->kb);
    }

    /**
     * Gera um nome único para o arquivo
     */
    protected function generateFileName($oldName){
        return md5(date('dmYHis') . $oldName);
    }

    /**
     * Verifica se a extensão é válida para o arquivo enviado e se o tamanho é inferior ou igual ao permitido
     */
    protected function validateExtensionAndSizeOfFile(): bool{
        return in_array($this->ext, $this->fileTypes) && $this->fileSize <= $this->acceptedSize;
    }

    /**
     * Envia uma mensagem de erro
     */
    protected function errorResponse(string $message = 'Upload error'){
        return [
            'success' => false,
            'message' => $message,
        ];
    }

     /**
     * Envia uma mensagem de sucesso
     */
    protected function successResponse(string $message = 'Upload success'){
        return [
            'success' => true,
            'message' => $message,
        ];
    }

    
     /**
     * Realiza o upload do arquivo enviado
     */
    protected function upload(){
        if(defined('UPLOAD_DIR') && !empty(UPLOAD_DIR)){
            if(move_uploaded_file($this->file['tmp_name'],  UPLOAD_DIR . $this->fileName . "." . $this->ext)){
                return $this->successResponse('Sucesso no upload!');
            }else{
                return $this->errorResponse('Falha no upload!');
            }
        }else{
            return $this->errorResponse('A pasta padrão de upload não está definida');
        }
    }

}