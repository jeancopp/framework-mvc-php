<?php

    class PDOHelper{
        static function newDefaultPDO(){
            $ini = new IniFileHelper(ARQ_INI);
            $bd = $ini->getAllOptionsOfSection('banco_dados');
            $pdo = new PDO("mysql:host={$bd['host']};dbname={$bd['dbname']}","{$bd['user']}","{$bd['pass']}");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
            return $pdo;
            
        }
    }