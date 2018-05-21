<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es de montagem do m�vel no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Montagem {
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
     * Vari�vel que recebe o c�digo da data de montagem.
     * 
     * @access private
     * @var string
     */
    private $data;
    
    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectar();
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
     * Armazena o c�digo da data da montagem na vari�vel.
     * 
     * @access public
     * @param string $valor Data da montagem.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
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
     * Armazena as informa��es da montagem no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar(){
        if($this->isVendaMovelOk() && isset($this->data)){
            $stmt = $this->conexao->prepare("INSERT INTO montagem VALUES (?,?)");
            $stmt->bindParam(1, $this->vendaMovel);
            $stmt->bindParam(2, $this->data);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informa��es da montagem no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isVendaMovelOk() && isset($this->data)){
            $stmt = $this->conexao->prepare("UPDATE montagem SET data_montagem=? WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->data);
            $stmt->bindParam(3, $this->vendaMovel);
            
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
            $stmt = $this->conexao->prepare("DELETE FROM montagem WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->vendaMovel);
            
            return $stmt->execute();
        }
    }
    
    /**
     * Retorna informa��es da(s) montagem(ns)
     * 
     * @access public
     * @return array Retorna lista de informa��es da(s) montagem(ns)
     */
    public function obter($vendaMovel=NULL){
        if(!empty($vendaMovel)){
            $this->vendaMovel = (int) $vendaMovel;
        }
        
        $query = "SELECT id_movel_possui_venda_FK, data_montagem FROM montagem";
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
     * Retorna todas as montagens registradas num per�do de tempo determinado.
     * 
     * @access public
     * @return array Retorna todas as montagens registradas no Sistema.
     */
    public function obterPorIntervaloDeDatas($data1, $data2){
        if($data2<$data1){
            $aux = $data2;
            $data2 = $data1;
            $data1 = $aux;
        }
        
        $stmt = $this->conexao->prepare("SELECT id_movel_possui_venda_FK, data_montagem FROM montagem WHERE data_montagem BETWEEN ? and ?");
        $stmt->bindParam(1, $data1);
        $stmt->bindParam(1, $data2);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Confere se existe ou n�o montagem do m�vel selecionado.
     * 
     * @access public
     * @return boolean return TRUE se tem montagem do m�vel selecionado e FALSE se n�o houver.
     */
    public function temMontagem(){
        if($this->isVendaMovelOk()){
            $stmt = $this->conexao->prepare("SELECT count(data_montagem) FROM montagem WHERE id_movel_possui_venda_FK=?");
            $stmt->bindParam(1, $this->vendaMovel);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($resultado['count(data_montagem)']==1){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}
