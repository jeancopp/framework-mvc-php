<?php
    include 'system/constant.php'; 
    
    require_once 'system/system.php';
    require_once 'system/Controller.php';
    require_once 'system/Model.php';
    
    function __autoload($file){
        if( strpos($file,'Helper' ) > 0 && file_exists(HELPERS . $file . '.php')){
            require_once(HELPERS . $file . '.php');
        }else if(file_exists(MODELS . $file . '.php')){
            require_once(MODELS . $file . '.php');
        }else{
            die('Arquivo referente a classe '.$file.' não foi encontrado');
        }           
    }
    $start = new System();
    $start->run();
