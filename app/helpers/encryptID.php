<?php

function encryptId($id){
    return base64_encode(openssl_encrypt($id, 'aes-256-cbc', SECRET_KEY, 0, SECRET_KEY));
}

function decryptId($id){
    return openssl_decrypt(base64_decode($id), 'aes-256-cbc', SECRET_KEY, 0, SECRET_KEY);
}

