<?php
    
    class index extends Controller{
        public function index_action(){
           $teste = new PDOHelper;
           $this->view("index",$this->_params);           
        }
    }
