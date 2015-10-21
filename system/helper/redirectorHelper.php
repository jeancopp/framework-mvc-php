<?php

    class RedirectorHelper{
        protected  $_parametros = array();
        
        protected function go($info){
            header('Location: /'.$info);
        }
        protected function getUrlParameters(){
            $parametros = "";
            foreach ($this->_parametros as $nome => $valor){
                $parametros .= $nome . "/" . $valor."/";
            }
            return $parametros;
        }
        
        public function goToController($controller) {
            $this->go($controller . '/index/' . $this->getUrlParameters());
        }
                
        public function goToAction($action) {
            $this->go($this->getCurrentController() . '/'.$action.'/' . $this->getUrlParameters());
        }
        
        public function goToControllerAction($controller, $action) {
            $this->go($controller .'/'. $action . '/' . $this->getUrlParameters());
        }
        
        public function goToIndex() {
            $this->goToController('index');
        }
        
        public function goToUrl($url) {
            header('Location: /'.$url);
        }
        
        public function setUrlParameter($nome, $valor){
            $this->_parametros[$nome] = $valor;
            return $this;
        }
        
        public function getCurrentController() {
            global  $start;
            return $start->_controller;
        }
     
        public function getCurrentAction() {
            global  $start;
            return $start->_action;
        }
        
        
    }