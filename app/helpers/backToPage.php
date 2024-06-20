<?php

use app\models\Permissions;
/**
 * A função hashSet tem o objetivo de devolver ao usuário um array de valores únicos
 */
// function hashSet(array $arr){
//     $set = [];

//     foreach($arr as $key => $value){
//         if(!isset($set[$value])){
//             $set[$key] = $value;
//         }
//     }
//     return $set;
// }

/**
 * Escaneia diretórios recursivamente, ou seja, diretórios e sub-diretórios
 * @param string $path - o caminho ou pasta a qual deseja escanear
 * @param array $ignorePathsAndFiles - um array de arquivos ou pastas os quais deseja ignorar ao escanear
 * @return array
 */
function scandirectories($path, $ignorePathsAndFiles = []){
    $files = [];
    $items = array_diff(scandir($path), ['.','..']);

    foreach($items as $item){
        if(!in_array($item, $ignorePathsAndFiles)){
            $fullPath = $path . "/$item";
            if(is_dir($fullPath)){
                $files = array_merge($files, scandirectories($fullPath));            
            }else{
                $files[] = $fullPath;
            }
        }
    }
    return $files;
}

/**
 * Verifica se um array é associativo ou não
 * @param array $arr - o array a ser verificado
 * @return bool
 */
function isList($arr){
    if(is_array($arr)){
        return count(array_filter(array_keys($arr), 'is_string')) > 0;
    }
    throw new \Exception('O atributo $arr deve ser um array.');
}
function encrypt($message, $key = SECRET_KEY){
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encrypted = openssl_encrypt($message, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    $encryptedWithIv = $iv . $encrypted;
    return $encryptedWithIv;
}

function decrypt($encryptedMessage, $key = SECRET_KEY){
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedMessage, 0,$ivLength);
    $messageWithoutIv = substr($encryptedMessage, $ivLength);
    $decryptedMessage = openssl_decrypt($messageWithoutIv, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedMessage;
}

function backToPage($to){
    header("location: " . URL_BASE . $to);
    exit;
}

function today($format = 'Y-m-d'){
    return (new DateTime('America/Fortaleza'))->format($format);
}

function convertDate($date, $format='d/m/Y'){
    return date($format, strtotime($date));
}

function converCurrency($number, string $currency = 'R$',int $qtdDecimais = 2,string $sepDecimais = ',', string $sepThousands = '.'){
    return $currency . " " .number_format($number, intval($qtdDecimais),$sepDecimais, $sepThousands);
}

/**
 * Converte um número para um formato escolhido
 * @param int|float $number - O número no formato float ou inteiro a ser convertido.
 * @param int $qtdDecimais -  O número de casas decimais.
 * @param string $sepDecimais - O separador dos decimais, por padrão será '.' (ponto).
 * @param string $sepThousands - O separador dos milhares, por padrão será '' (vazio).
 * @return float - retorna um número float
 */
function formatNumber(int|float $number, int $qtdDecimais = 2,string $sepDecimais = '.', string $sepThousands = ''){
    if(is_int($qtdDecimais)){
        return number_format($number, intval($qtdDecimais),$sepDecimais, $sepThousands);
    }
    return false;
}

function removerNonoDigito($number){
    $number = str_replace(['(',')','-',' '],'',convertPhone($number));
    $ddd = $number ? $number[0].$number[1]:'';
    if($number && $ddd != COUNTRY_CODE){
        if(strlen($number) >= 11){
            $nonoDig = $number[2];
            if($nonoDig == '9' || $nonoDig == 9){
                $number = ltrim($number, $ddd);
                $number = COUNTRY_CODE.$ddd.substr($number, 1);
            }
        }else{
            $number = COUNTRY_CODE.$number;
        }
    }
    return $number;
}
function convertPhone($phone, $formato = '(%codigo%) %parte2%-%parte3%'){
    $phone = preg_replace('/\D/', '', $phone);
    if(strlen($phone) === 10){
        $parte1 = substr($phone, 0, 2);
        $parte2 = substr($phone, 2, 4);
        $parte3 = substr($phone, 6, 4);
        $telefoneFormatado = str_replace(['%codigo%', '%parte2%', '%parte3%'],[$parte1, $parte2, $parte3], $formato);
        return $telefoneFormatado;
    }else if(strlen($phone) === 11){
        $parte1 = substr($phone, 0, 2);
        $parte2 = substr($phone, 2, 5);
        $parte3 = substr($phone, 7, 4);
        $telefoneFormatado = str_replace(['%codigo%', '%parte2%', '%parte3%'],[$parte1, $parte2, $parte3], $formato);
        return $telefoneFormatado;
    }
}

/**
 * Função que retorna a diferença de dias entre duas datas
 * @param string $date1 - a data 1
 * @param string $date2 - a data 2
 * @return int
 */
function daysBetweenDates($date1, $date2){
    $date1New = new DateTime($date1);
    $date2New = new DateTime($date2);
    return $date1New->diff($date2New)->days;
}

/**
 * Função que retorna para a rota anterior a requisitada
 * @param string $option - algum caminho de id html, ex.: #pills-profile, #main-content
 * @return void
 */
function goBack(string $option = ''){
    header("location:" . $_SERVER['HTTP_REFERER'] . $option);
    die;
}

/**
 * Função que aponta para a pasta assets e carrega os arquivos necessários informados pelo usuário
 * @param string $file - caminho até o arquivo
 * @return string
 */
function asset($file){
    return URL_BASE . 'assets/' . $file;
}

/**
 * Função que aponta para uma rota especificada pelo usuário
 * @param string $route - caminho até a rota, ex.: 'admin.alunos', 'admin/alunos'
 * @return string
 */
function route($route){
    if(!str_contains($route, ".")){
        return URL_BASE . $route;
    }else{
        $route = str_replace(".", "/", $route);
        return URL_BASE . $route;
    }
}

function plusDaysInDate($date, $qtdDays, $format = 'Y-m-d'){
    return (new DateTime($date))->modify("+ $qtdDays days" )->format($format);
}

function component($component, $data = []){
    if(str_contains($component, ".php")){
        $file = PATH_COMPONENTS . $component;
    }else{
        $file = PATH_COMPONENTS . $component . ".php";
    }
    try{
        if(file_exists($file)){
            extract($data);
            require $file;
        }else{
            throw new \Exception('O componente não foi encontrado');
        }
    }catch(\Exception $e){
        echo 'O componente não foi encontrado.';
        exit;
    }
}

function redirect($url){
    header('location:' . URL_BASE . $url);
    return;
}

function dd($data){
    $html = <<<HTML
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/go.min.js"></script>
    </head>
    <body>
    HTML;
    $html.= "<div class='view-container'>";
    $html.="<div class='code-block'>";
    $html.= "<pre> <code class='language-php'>";
    $html.= htmlspecialchars(var_export($data, true));
    $html.= "</code>";
    $html.= "</pre>";
    $html.="</div>";
    $html.= "</div>";
    $html.= <<<HTML

    <script>
        document.addEventListener("DOMContentLoaded", (e)=>{
            document.querySelectorAll("pre code").forEach( block =>{
                hljs.highlightElement(block);
            })
        })
    </script>
    </body>
    </html>
    HTML;
    echo $html;
    die;
}

function getRandomLetters($qtd = 3){
    $alphabet = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $letters = '';
    for($i = 0; $i < $qtd; $i++){
        $letters.= $alphabet[random_int(0, 26)];
    }
    return $letters;
}

function getRandomNumber($qtd = 1){
    $numbers = '';
    for($i = 0; $i < $qtd; $i++){
        $numbers.= random_int(0, 9);
    }
    return $numbers;
}

function historyBack(){
    $html = <<<HTML
        <script>
            history.back();
        </script>
    HTML;
    return $html;
}

function isPermissionBlocked($url, $idcargo, $HTML = ''){
    $permissions = (new Permissions)->fetch(
    ['permissions.id', 'permissions.permission_name'], where:'
        permissions.permission_name = :url 
        AND
        pb.idcargo = :idcargo
    ',data:['url' => $url, 'idcargo' => $idcargo], join:'
        LEFT JOIN permissao_bloqueada pb ON pb.idpermission = permissions.id
    ');
    if(!$permissions && $HTML){
        echo $HTML;
    }elseif(!$permissions && !$HTML){
        return true;
    }
    return;
}

function back(){
    $_previous = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']:false;
    if($_previous){
        header("location:" . $_previous);
        exit;
    }else{
        echo historyBack();
        exit;
    }
}

function arrayFilter($array, $key = '', $search = ''){
    if(is_array($array)){
        if($key && $search){
            return array_values(array_filter($array, function($value) use($key, $search){
                if(is_object($value)){
                    if($value->$key == $search ){
                        return $value;
                    }
                }else if(is_array($value)){
                    if($value[$key] == $search ){
                        return $value;
                    }                 
                }
            }));
        }else{
            return array_values(array_filter($array, fn($value) => $value));
        }
    }
}