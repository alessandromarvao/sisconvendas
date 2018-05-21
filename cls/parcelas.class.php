<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações relacionadas às parcelas do pagamento no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Parcelas {
    /** 
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Variável que recebe o código do pagamento da venda.
     * 
     * @access private
     * @var int
     */
    private $pagamento;
    
    /**
     * Variável que recebe a quantidade de parcelas no pagamento.
     * 
     * @access private
     * @var int
     */
    private $qtdeParcelas;
    
    /**
     * Variável que recebe valor pendente no pagamento.
     * 
     * @access private
     * @var double
     */
    private $valorPendencia;
    
    /**
     * Inicia as operações no BD.
     * 
     * @return void
     */
    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectar();
    }
    
    /**
     * Retorna o valor da variável desejada.
     * 
     * @param string $nome Variável desejada.
     * @return string Retorna a informação da variável desejada.
     */
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena o código do pagamento na variável.
     * 
     * @access public
     * @param int $valor Código do pagamento.
     * @return void
     */
    public function setPagamento($valor){
        $this->pagamento = (int) $valor;
    }
    
    /**
     * Armazena o código do pagamento na variável.
     * 
     * @access public
     * @param int $valor Código do pagamento.
     * @return void
     */
    public function setQtdeParcelas($valor){
        $this->qtdeParcelas = (int) $valor;
    }
    
    /**
     * Armazena o código do pagamento na variável.
     * 
     * @access public
     * @param int $valor Código do pagamento.
     * @return void
     */
    public function setValorPendencia($valor){
        $lista = explode(",", $valor);
        $string = implode(".", $lista);
        $num = (double) $string;
        $preco = number_format($num,2,".","");
        $this->valorPendencia = (double) $preco;
    }
    
    /**
     * Confere se a variável $pagamento existe e tem valor maior que 0
     * 
     * @return boolean Retorna TRUE se a condição for válida
     * e FALSE se não for.
     */
    private function isPagamentoOk(){
        if(isset($this->pagamento) && $this->pagamento>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a variável $qtdeParcelas existe e tem valor maior que 0
     * 
     * @return boolean Retorna TRUE se a condição for válida
     * e FALSE se não for.
     */
    private function isQtdeOk(){
        if(isset($this->qtdeParcelas) && $this->qtdeParcelas>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a variável $valorPendencia existe e tem valor maior que 0
     * 
     * @return boolean Retorna TRUE se a condição for válida
     * e FALSE se não for.
     */
    private function isValorOk(){
        if(isset($this->valorPendencia) && $this->valorPendencia>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informações do pagamento parcelado no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar(){
        
        if($this->isPagamentoOk() && $this->isQtdeOk() && $this->isValorOk()){
            $stmt = $this->conexao->prepare("INSERT INTO parcelas VALUES (?, ?, ?)");
            $stmt->bindParam(1, $this->pagamento);
            $stmt->bindParam(2, $this->qtdeParcelas);
            $stmt->bindParam(3, $this->valorPendencia);
            
//        return "INSERT INTO parcelas VALUES ($this->pagamento, $this->qtdeParcelas, $this->valorPendencia);";
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informações do pagamento parcelado no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isPagamentoOk() && $this->isQtdeOk() && $this->isValorOk()){
            $stmt = $this->conexao->prepare("UPDATE parcelas SET qtde_parcelas=?, valor_parcela=? WHERE id_pgmto_FK=?");
            $stmt->bindParam(1, $this->qtdeParcelas);
            $stmt->bindParam(2, $this->valorPendencia);
            $stmt->bindParam(3, $this->pagamento);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta do Banco de Dados as informações do pagamento parcelado.
     * 
     * @access public
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isPagamentoOk()){
            $stmt = $this->conexao->prepare("DELETE FROM parcelas WHERE id_pgmto_FK=?");
            $stmt->bindParam(1, $this->pagamento);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados do(s) pagamento(s) parcelado(s) no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos e suas informações.
     */
    public function obter(){
        $query = "SELECT id_pagmto_FK, qtde_parcelas, valor_parcela FROM parcelas";
        
        if($this->isPagamentoOk()){
            $query .= " WHERE id_pagmto_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->pagamento);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Confere se o pagamento foi parcelado ou não.
     * 
     * @return boolean Retorna TRUE se existe pagamento parcelado e FALSE se não.
     */
    public function confereParcelaPorPagamento(){
        if($this->isPagamentoOk()){
            $stmt = $this->conexao->prepare("SELECT count(valor_parcela) FROM parcelas WHERE id_pagmto_FK=?");
            $stmt->bindParam(1, $this->pagamento);
            $stmt->execute();
            $aux = $stmt->fetch(PDO::FETCH_ASSOC);
            $res = (int) $aux['count(valor_parcela)'];
            
            if($res==0){
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
}
