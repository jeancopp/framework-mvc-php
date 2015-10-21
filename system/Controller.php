<?php

    class Controller extends System{
        protected function view( $nome, $subtitulo = "",$vars = null,  $incluir_cabec = true,$incluir_rodape = true ){
            $view_path = VIEWS . $nome.'.phtml';
            if (!file_exists($view_path)){
                die("View({$view_path}) não encontrada");
            }            
            if (is_array($vars) && count($vars) > 0 ) {
                extract($vars, EXTR_PREFIX_ALL, 'view');
            }
            if($incluir_cabec){
                include_once "system/cabecalho.phtml";
            }
            require_once($view_path);
            if( $incluir_rodape ){
                include_once "system/rodape.phtml";
            }
        }
        
        public function init(){}
    }
    