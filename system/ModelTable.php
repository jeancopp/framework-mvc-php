<?php
    class ModelTable extends System{
        public $_tabelas = array();

        public function __construct($tabelas = null) {
            parent::__construct();
            $this->_tabelas = ($tabelas == null ? ModelTable::getListTabelas() : $tabelas);
        }
        
        public function gerarModels(){
            $erro = array();
            foreach ($this->_tabelas as $tabela){
                $caminho = MODELS.ucfirst($tabela).".php";
                if(file_exists($caminho)){
                    $erro[] = "{$tabela}: Já existe um arquivo referente a regra para criação(nome-da-tabela.php)";
                }else{
                    $arquivo = fopen($caminho,"x+");
                    if(!$arquivo){
                        $erro[] = "{$tabela}: Não foi possível criar o arquivo";
                    }else{
                        fwrite($arquivo, $this->gerarModel($tabela) );
                        fclose($arquivo);
                    }                            
                }
            }
            if(sizeof($erro) > 0){
                return implode("<br/>\n", $erro);
            }
            return true;
        }
        public function gerarModel($tabela){
            $tabela = ucfirst($tabela);
            $campos = $this->criarMatrizCampos($tabela);
            $saida = "<?php\n"
                    . "     class {$tabela} extends Model{ \n\t"
                    . $this->addAtributos($campos)
                    . $this->addMetodos($tabela,$campos);
            $saida .= "\n     }";
            
            return $saida;            
        }
        private function addMetodos($tabela, array $campos){
            foreach($campos as $i => $c){
                $campos_novo[$i] = $c["campo"];
                if($c["obs"] == "PRI"){
                    $campos_codigo[$i] = $c["campo"];
                }
            }
            $campos_saida = var_export($campos_novo,true);
            $campos_codigo_saida = var_export($campos_codigo,true);
            
            $saida = array("constructor"=>"\n\tpublic function __construct() {"
                . "\n\t\tparent::__construct(\"{$tabela}\",\n{$campos_saida},\n{$campos_codigo_saida}\n);"
                . "\n\t}");           
            return implode("\n\n",$saida);
        }

        private function addAtributos(array $campos){
            $saida = "";            
            foreach ($campos as $campo_tabela => $dadosCampo){      
                $saida .=(!empty($dadosCampo["obs"]) ? "/*{$dadosCampo["obs"]}*/\n\t" : ""  )
                       . "protected \${$dadosCampo["campo"]};\n\t";
            }
            return $saida;
        }
        
        private function criarMatrizCampos($tabela){
            $campos = ModelTable::getDescTabela($tabela);
            foreach ($campos as $describle){      
                if(empty($describle['Key']) || $describle['Key'] == "PRI"){// se não for uma FK
                    $p = strpos($describle['Field'], '_');
                    $campo = substr($describle['Field'],$p+1); // copia depois do primeiro "_"
                }else{
                    $campo = $describle['Field'];
                }
                $campo = strtolower($campo);
                if(strpos($campo, "_") > 0){
                    $p = Strpos($campo, '_');                        
                    $aux = ucwords(str_replace("_"," ",substr($campo, $p+1)));
                    $campo = substr($campo, 0, $p) . str_replace(" ","",$aux );
                }                
                $camposSaida[$describle['Field']] = array("campo" => "_".$campo , "obs" => $describle['Key']);
            }
            return $camposSaida;
        }
        
        public static function getListTabelas(){
            $pdo = PDOHelper::newDefaultPDO();
            $query = $pdo->query("SHOW TABLES;"); 
            $r = $query->fetchAll(PDO::FETCH_NUM);
            $tabelas = array();
            foreach ($r as $value) {
                $tabelas[] = $value[0];
            }
            return $tabelas;            
        }
        
        public static function getDescTabela($tabela){
            $pdo = PDOHelper::newDefaultPDO();
            $query = $pdo->query("desc {$tabela};"); 
            $r = $query->fetchAll(PDO::FETCH_ASSOC);
            
            return $r;            
        }
        
    }