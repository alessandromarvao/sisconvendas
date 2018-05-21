<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações de entrega do móvel no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Entrega {
    /**
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Variável que recebe o código da venda do móvel selecionado.
     * 
     * @access private
     * @var int
     */
    private $vendaMovel;
    
    /**
     * Variável que recebe o código da data de entrega.
     * 
     * @access private
     * @var string
     */
    private $data;
    
    /**
     * Variável que recebe o endereço da entrega.
     * 
     * @access private
     * @var string
     */
    private $endereco;
    
    /**
     * Variável que recebe a referência do endereço da entrega.
     * 
     * @access private
     * @var string
     */
    private $referencia;
    
    /**
     * Inicia as operações das entregas no Banco de Dados.
     * 
     * @return void
     */
    function __construct(){
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com parâmetros, encaminha ao construtor desejado
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }
    
    /**
     * Inicia um objeto de Entrega já com o código da compra do móvel sitado.
     * 
     * @param int $movelVendido
     * @return void
     */
    function __construct1($movelVendido){
        $this->vendaMovel = $movelVendido;
    }
    
    /**
     * Inicia um objeto de Entrega já com o código da compra do móvel sitado e data da entrega.
     * 
     * @param type $movelVendido
     * @param type $data
     * @return void
     */
    function __construct2($movelVendido, $data){
        $this->vendaMovel = $movelVendido;
        $this->data = $data;
    }
    
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena o código da venda do móvel na variável.
     * 
     * @access public
     * @param int $valor Código da venda do móvel.
     * @return void
     */
    public function setVendaMovel($valor){
        $this->vendaMovel = (int) $valor;
    }
    
    /**
     * Armazena o código da data da entrega na variável.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Armazena a data da entrega na variável.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setEndereco($valor){
        $this->endereco = $valor;
    }
    
    /**
     * Armazena a data da entrega na variável.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setReferencia($valor){
        $this->referencia = $valor;
    }
    
    /**
     * Confere se a variável $vendaMovel existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condição for válida
     * e FALSE se não for.
     */
    private function isVendaMovelOk(){
        if(isset($this->vendaMovel) && $this->vendaMovel>0){
            return TRUE;
        } else {
            return FALSE; 
        }
    }
    
    /**
     * Armazena as informações da entrega no Banco de Dados.
     * 
     * @access public
     * @param int $vendaDoMovel Código da venda do móvel.
     * @param date $data Data da entrega do móvel.
     * @param string $endereco Endereço de entrega.
     * @param string $referencia Referência da residência da entrega.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($vendaDoMovel, $data, $endereco, $referencia){
        $this->vendaMovel = $vendaDoMovel;
        $this->data = $data;
        $this->endereco = $endereco;
        $this->referencia = $referencia;
        
        $stmt = $this->conexao->prepare("INSERT INTO entrega VALUES (?,?,?,?)");
        $stmt->bindParam(1, $this->vendaMovel);
        $stmt->bindParam(2, $this->data);
        $stmt->bindParam(3, $this->endereco);
        $stmt->bindParam(4, $this->referencia);

        return $stmt->execute();
    }
    
    /**
     * Modifica as informações da entrega no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isVendaMovelOk() && isset($this->data) && isset($this->endereco) && isset($this->referencia)){
            $stmt = $this->conexao->prepare("UPDATE entrega SET data_entrega=?, end_entrega=?, referencia_entrega WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->data);
            $stmt->bindParam(2, $this->endereco);
            $stmt->bindParam(3, $this->referencia);
            $stmt->bindParam(4, $this->vendaMovel);
            
            return $stmt->execute();
        }
    }
    
    /**
     * Deleta do Banco de Dados as informações da entrega selecionada.
     * 
     * @access public
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isVendaMovelOk()){
            $stmt = $this->conexao->prepare("DELETE FROM entrega WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->vendaMovel);
            
            return $stmt->execute();
        }
    }
    
    /**
     * Retorna informações da(s) entrega(s)
     * 
     * @access public
     * @return array Retorna lista de informações da(s) entrega(s)
     */
    public function obter($idVenda=null){
        if(!empty($idVenda)){
            $this->vendaMovel = (int) $idVenda;
        }
        
        $query = "SELECT id_movel_possui_venda_FK, data_entrega, end_entrega, referencia_entrega FROM entrega";
        if($this->isVendaMovelOk()){
            $query .= " WHERE id_movel_possui_venda_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->vendaMovel);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->data)){
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->data);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->endereco)){
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->endereco);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna as entregas realizadas no prazo determinado
     * 
     * @param date $data1 Data Inicial
     * @param date $data2 Data Final
     * @return array[] Lista de informações das entregas realizadas.
     */
    public function obterPorIntervaloDeDatas($data1, $data2){
        if($data2<$data1){
            $aux = $data2;
            $data2 = $data1;
            $data1 = $aux;
        }
        
        $stmt = $this->conexao->prepare("SELECT id_movel_possui_venda_FK, data_entrega, end_entrega, referencia_entrega FROM entrega WHERE data_entrega BETWEEN ? and ?");
        $stmt->bindParam(1, $data1);
        $stmt->bindParam(1, $data2);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Confere se existe móvel a fazer entrega.
     * 
     * @return boolean Retorna TRUE se existe móvel a ser entregue na venda de móvel citada e FALSE se não.
     */
    public function temEntrega(){
        if($this->isVendaMovelOk()){
            $stmt = $this->conexao->prepare("SELECT count(data_entrega) FROM entrega WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->vendaMovel);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($resultado['count(data_entrega)']==1){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}