<?php


function LinkButton(array $props = [], array $children = []){

    $html = "<a ";

    foreach($props as $key => $value){
        $html.= "{$key}='{$value}' ";
    }

    $html.=">";

    foreach($children as $child){
        $html.= $child;
    }

    $html.= "</a>";
    return $html;
}

function Button(array $props = [], array $children = []){

    $html = "<button ";

    foreach($props as $key => $value){
        $html.= "{$key}='{$value}' ";
    }

    $html.=">";

    foreach($children as $child){
        $html.= $child;
    }

    $html.= "</button>";
    return $html;
}

