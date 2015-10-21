<?php
    require_once 'system/ModelTable.php';
    
    class Morgana extends Controller{
        public function index_action(){
            $this->view("morgana/selecao_tabelas", " - Projeto via MorganaFramework");            
        }
        public function gerar_models(){
            $tabelas = $_POST['tabela'];
            $model = new ModelTable($tabelas);
            $this->view("morgana/lista_gerada", " - Projeto via MorganaFramework", $resposta = $model->gerarModels() ) ;
        }
      
  
    }

