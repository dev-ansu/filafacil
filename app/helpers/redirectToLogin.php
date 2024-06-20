<?php

function redirectToLogin($to = ''){
    $url = $to ? $to:"";
    if($url){
        header("Location:" . URL_BASE . $to . "/login");
    }
    header("Location:" . URL_BASE . "login");
}

function hexParaRgb($hex) {
    // Remove qualquer caractere não válido do valor hexadecimal
    $hex = preg_replace('/[^a-fA-F0-9]/', '', $hex);

    // Se o comprimento do valor hexadecimal é diferente de 6 ou 3, não é válido
    if (strlen($hex) != 6 && strlen($hex) != 3) {
        return false;
    }

    // Adiciona zeros à esquerda, se o comprimento for 3
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Converte o valor hexadecimal para decimal
    $rgbArray = array(
        'r' => hexdec(substr($hex, 0, 2)),
        'g' => hexdec(substr($hex, 2, 2)),
        'b' => hexdec(substr($hex, 4, 2))
    );

    return $rgbArray;
}