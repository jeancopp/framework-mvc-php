<?php

    class IniFileHelper{
        private $_arquivo;
        private $_ini;
        
        public function __construct($arquivo) {
            $this->_arquivo = $arquivo;
            $this->load();
        }
        
        public function load(){
            $this->_ini = parse_ini_file($this->_arquivo, true);
        }
        
        public function getAll(){
            return $this->_ini;
        }
        
        public function getAllOptionsOfSection($secao){
            return $this->_ini[$secao];
        }
        
        public function getOptionOfSection($section, $option){
            $secao = $this->getAllOptionsOfSection($secao);
            return $secao[$option];
        }
        
    }
