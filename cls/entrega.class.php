<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es de entrega do m�vel no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Entrega {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo da venda do m�vel selecionado.
     * 
     * @access private
     * @var int
     */
    private $vendaMovel;
    
    /**
     * Vari�vel que recebe o c�digo da data de entrega.
     * 
     * @access private
     * @var string
     */
    private $data;
    
    /**
     * Vari�vel que recebe o endere�o da entrega.
     * 
     * @access private
     * @var string
     */
    private $endereco;
    
    /**
     * Vari�vel que recebe a refer�ncia do endere�o da entrega.
     * 
     * @access private
     * @var string
     */
    private $referencia;
    
    /**
     * Inicia as opera��es das entregas no Banco de Dados.
     * 
     * @return void
     */
    function __construct(){
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com par�metros, encaminha ao construtor desejado
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }
    
    /**
     * Inicia um objeto de Entrega j� com o c�digo da compra do m�vel sitado.
     * 
     * @param int $movelVendido
     * @return void
     */
    function __construct1($movelVendido){
        $this->vendaMovel = $movelVendido;
    }
    
    /**
     * Inicia um objeto de Entrega j� com o c�digo da compra do m�vel sitado e data da entrega.
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
     * Armazena o c�digo da venda do m�vel na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da venda do m�vel.
     * @return void
     */
    public function setVendaMovel($valor){
        $this->vendaMovel = (int) $valor;
    }
    
    /**
     * Armazena o c�digo da data da entrega na vari�vel.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Armazena a data da entrega na vari�vel.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setEndereco($valor){
        $this->endereco = $valor;
    }
    
    /**
     * Armazena a data da entrega na vari�vel.
     * 
     * @access public
     * @param string $valor Data da entrega.
     * @return void
     */
    public function setReferencia($valor){
        $this->referencia = $valor;
    }
    
    /**
     * Confere se a vari�vel $vendaMovel existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isVendaMovelOk(){
        if(isset($this->vendaMovel) && $this->vendaMovel>0){
            return TRUE;
        } else {
            return FALSE; 
        }
    }
    
    /**
     * Armazena as informa��es da entrega no Banco de Dados.
     * 
     * @access public
     * @param int $vendaDoMovel C�digo da venda do m�vel.
     * @param date $data Data da entrega do m�vel.
     * @param string $endereco Endere�o de entrega.
     * @param string $referencia Refer�ncia da resid�ncia da entrega.
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
     * Modifica as informa��es da entrega no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
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
     * Deleta do Banco de Dados as informa��es da entrega selecionada.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
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
     * Retorna informa��es da(s) entrega(s)
     * 
     * @access public
     * @return array Retorna lista de informa��es da(s) entrega(s)
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
     * @return array[] Lista de informa��es das entregas realizadas.
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
     * Confere se existe m�vel a fazer entrega.
     * 
     * @return boolean Retorna TRUE se existe m�vel a ser entregue na venda de m�vel citada e FALSE se n�o.
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