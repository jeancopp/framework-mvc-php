<?php

    class SessionHelper{
        
        public function addValue($nome, $valor) {
            $_SESSION[$nome] = $valor;
            return $this;
        }
        
        public function getValue($nome){
            return $_SESSION[$nome];
        }
        
        public function unSetValue($nome) {
            if($this->valueExists($nome)){
                unset($_SESSION[$nome]);
            }
            return $this;
            
        }        
        
        public function valueExists($paramsession){
            return isset($_SERVER[$paramsession]);
        }
        
        
    }