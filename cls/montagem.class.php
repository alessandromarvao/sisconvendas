<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações de montagem do móvel no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Montagem {
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
     * Variável que recebe o código da data de montagem.
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
     * Armazena o código da data da montagem na variável.
     * 
     * @access public
     * @param string $valor Data da montagem.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
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
     * Armazena as informações da montagem no Banco de Dados.
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
     * Modifica as informações da montagem no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
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
     * Deleta do Banco de Dados as informações da entrega selecionada.
     * 
     * @access public
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
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
     * Retorna informações da(s) montagem(ns)
     * 
     * @access public
     * @return array Retorna lista de informações da(s) montagem(ns)
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
     * Retorna todas as montagens registradas num perído de tempo determinado.
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
     * Confere se existe ou não montagem do móvel selecionado.
     * 
     * @access public
     * @return boolean return TRUE se tem montagem do móvel selecionado e FALSE se não houver.
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
