<?php
    class System{
        private $_url;
        private $_explode;
        public  $_controller;
        public $_action;
        public $_params;
        
        public function __construct() {
            $this->setUrl();
            $this->setExplode();
            $this->setController();
            $this->setAction();
            $this->setParams();
        }
        
        private function setUrl(){
            $_GET['url'] = isset( $_GET['url']) ? $_GET['url'] : 'index/index_action' ;
            $this->_url = $_GET['url'];
        }
        
        private function setExplode(){
            $this->_explode = explode('/', $this->_url);
        }
        
        private function setController(){
            $this->_controller = $this->_explode[0];
        }
        
        private function setAction(){
            $ac = ( (!isset($this->_explode[1]))
                    || $this->_explode[1] == null 
                    || $this->_explode[1] == "index" ? 
                    "index_action" : $this->_explode[1] );
            $this->_action = $ac;
        }
        
        private function setParams(){
            unset($this->_explode[0],$this->_explode[1]);
            if ( end($this->_explode) == NULL ){
                array_pop($this->_explode);
            }
            $num_parametros = count($this->_explode);
            if( $num_parametros % 2 != 0 || $num_parametros == 0 || empty($this->_explode)) {
                $this->_params = array();
            }else{
                $i = 0;
                foreach ($this->_explode as $valor){
                    if($i % 2 == 0 ){
                      $keys[] = $valor;
                    }else{
                      $values[] = $valor;  
                    }
                    $i++;                        
                }
                $this->_params = array_combine($keys, $values);
            }            
        }
        public function getParam( $parambyname ){
            return ( isset($this->_params[$parambyname]) ? $this->_params[$parambyname] : "" ) ;
        }
        
        public function run(){
            
            $controller_path = CONTROLLERS . $this->_controller . 'Controller.php';
            if ( !\file_exists($controller_path) ){
                die("Houve um erro. Controller $this->_controller nao encontrado".$controller_path);}
            require_once $controller_path;
            $app = new $this->_controller();
            if (!method_exists($app, $this->_action)) {
                die('Houve um erro. Action não encontrada!');
            }

            $action = $this->_action;
            $app->init();
            $app->$action();
        }
                
    }