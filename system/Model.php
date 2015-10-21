<?php

    class Model{
        const NOME_CAMPO_CODIGO = 0;
        const ATRIB_CAMPO_CODIGO = 1;
        
        protected $db;
        protected $_tabela;
        protected $_campoCodigo = array();
        protected $_campos;
        /* 
         * campo na tabela => nome do atribuito
         * PES_CODIGO => _codigo;
         */
        
        public function __construct($tabela,array $camposCodigo,Array $campos) {
            $this->db = PDOHelper::newDefaultPDO();
            $this->_tabela = $tabela;
            $this->_campoCodigo = $camposCodigo;
            $this->_campos = $campos;
            foreach( $this->_campoCodigo as $cc ){
                $atributo = $this->_campos[$cc] ;
                if(isset($this->$atributo)){
                    $this->$atributo = 0;
                }
            }                            
        }

        public function save() {
        /* Salva o estado atual do objeto no banco. 
         * Havendo algum valor no campo código(diferente de null e 0), será update, se não, irá inserir
         * 
         * Se "$campo_codigo is [null, 0]", então o elemento não está no banco, logo é uma adição.
         * 
         * É garantido, no momento da criação do objeto, que o campo referente ao campo código seja valorado em 0
         */
            $dados = array();
            foreach ($this->_campos as $campo_tabela => $atributo){
                $aux = ( in_array($campo_tabela, $this->_campoCodigo) ? "": "'");
                $dados[] = "{$campo_tabela} = {$aux}{$this->$atributo}{$aux}"; 
             }
            return ($this->$campoCodigo == 0 ) ? $this->add($dados) : $this->change($dados);            
        }
	
	protected function add( array $dados) {
            $campos = implode(',', array_keys($dados));
            $valores = "'".implode("','", array_values($dados))."'";
            return $this->db->query("INSERT INTO `{$this->_tabela}`"."({$campos}) values ({$valores})");
        }
        
        public function browse( $where = null, $limit = null, $offset = null, $orderby = null, array $fields = null ) {
            $where = ( $where == null ? "" : "WHERE {$where}");
            $limit = ( $limit == null ? "" : "LIMIT {$limit}");
            $offset = ( $offset == null ? "" : "OFFSET {$offset}");
            $orderby = ( $orderby == null ? "" : "ORDER BY {$orderby}");
            $fields = ( isset($fields) && $fields != null ? implode(",", $fields) : " * ");
            
            return $this->browseSQLQuery("select {$fields} from `{$this->_tabela}` {$where} {$orderby} {$limit} {$offset}");
        }
        
        public function browseSQLQuery($SQL){
            $query = $this->db->query($SQL);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            return $query->fetchAll();            
        }
        
        protected function change(array $dados, $where = "") {
            $campos = array();
            foreach ($dados as $indice => $valor){
                $campos[] = "{$indice} = '{$valor}'"; 
            }
            $campos = implode(',',$campos);
            return $this->db->query("UPDATE {$this->_tabela} SET {$campos}  WHERE {$this->whereCampoCodigo($where)}");
        }
        
        protected function whereCampoCodigo($where){
            if( $where == "" || $where == NULL ){
                $condicao = array();
                foreach( $this->_campoCodigo as $cc ){
                    $atributo = $this->_campos[$cc] ;
                    $condicao[] = "{$cc} = {$this->$atributo}";
                }
                $where = implode(" AND ", $condicao);
            }
            return $where;            
        }


        public function remove( $where = null) {
            return $this->db->query("DELETE FROM {$this->_tabela} WHERE {$this->whereCampoCodigo($where)}");
        }
        
        
    }