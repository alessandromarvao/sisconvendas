<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es relacionadas ao 
 * pagamento da venda no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Pagamento {
    /** 
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo do pagamento da venda.
     * 
     * @access private
     * @var int
     */
    private $id;
    
    /**
     * Vari�vel que recebe o c�digo da nota de venda.
     * 
     * @access private
     * @var int
     */
    private $venda;
    
    /**
     * Vari�vel que recebe a forma de pagamento desejada.
     * 
     * @access private
     * @var int
     */
    private $forma;
    
    /**
     * Vari�vel que recebe o valor pago.
     * 
     * @access private
     * @var double
     */
    private $valor;
    
    /**
     * Inicia as opera��es no BD.
     * 
     * @return void
     */
    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectar();
    }
    
    /**
     * Retorna o valor da vari�vel desejada.
     * 
     * @param string $nome Vari�vel desejada.
     * @return string Retorna a informa��o da vari�vel desejada.
     */
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena o c�digo do pagamento na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo do pagamento.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }
    
    /**
     * Armazena o c�digo da nota de venda na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da nota de venda.
     * @return void
     */
    public function setVenda($valor){
        $this->venda = (int) $valor;
    }
    
    /**
     * Armazena o c�digo da nota de venda na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da nota de venda.
     * @return void
     */
    public function setForma($valor){
        $this->forma = (int) $valor;
    }
    
    /**
     * Armazena o valor do pagamento na vari�vel.
     * 
     * @access public
     * @param double $valor Valor do pagamento.
     * @return void
     */
    public function setValor($valor){
        $lista = explode(",", $valor);
        $string = implode(".", $lista);
        $num = (double) $string;
        $preco = number_format($num,2,".","");
        $this->valor = (double) $preco;
    }
    
    /**
     * Confere se a vari�vel $venda existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isVendaOk(){
        if(isset($this->venda) && $this->venda !== 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $id existe e tem valor maior que 0
     * 
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isIdOk(){
        if(isset($this->id) && $this->id > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function isFormaOk(){
        if(isset($this->forma) && $this->forma>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es do pagamento no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar(){
        if($this->isVendaOk() && !empty($this->valor) && $this->isFormaOk()){
            $stmt = $this->conexao->prepare("INSERT INTO pagamento (nota_venda_FK, id_forma_pgmto_FK, valor_pago) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $this->venda);
            $stmt->bindParam(2, $this->forma);
            $stmt->bindParam(3, $this->valor);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informa��es do pagamento no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isIdOk() && !empty($this->valor) && !empty($this->tipo)){
            $stmt = $this->conexao->prepare("UPDATE pagamento SET valor_pago=? WHERE id_pagmto=?");
            $stmt->bindParam(1, $this->valor);
            $stmt->bindParam(2, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta do Banco de Dados as informa��es do pagamento.
     * N�o poder� ser deletada do Banco de Dados o pagamento que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isIdOk()){
            $stmt = $this->conexao->prepare("DELETE FROM pagamento WHERE id_pagmto=?");
            $stmt->bindColumn(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados do(s) pagamento(s) no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos e suas informa��es.
     */
    public function obter(){
        $query = "SELECT a.id_pagmto, a.nota_venda_FK, a.id_forma_pgmto_FK,"
                . " a.valor_pago, b.forma_pgmnto FROM pagamento a,"
                . " formas_pgmnto b WHERE a.id_forma_pgmto_FK=b.id_forma_pgmto ";
        if($this->isIdOk()){   //busca pelo c�digo do pagamento
            $query .= " AND a.id_pagmto=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif($this->isVendaOk()) {     //busca pela nota de venda
            $query .= " AND a.nota_venda_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->venda);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($this->isFormaOk()) {
            $query .= " AND id_forma_pgmto_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->forma);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
            
        }
    }
    
    /**
     * Retorna o c�digo do �ltimo pagamento realizado.
     * 
     * @return int C�digo do �ltimo pagamento
     */
    public function retornarUltimoPagamento(){
        $stmt = $this->conexao->prepare("select max(id_pagmto) from pagamento");
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['max(id_pagmto)'];
    }
    
    /**
     * Confere se a nota de venda citada j� fora paga ou n�o.
     * 
     * @return boolean Retorna TRUE se o pagamento da nota de venda em quest�o j� fora realizado e FALSE se ainda n�o.
     */
    public function pagamentoRealizado(){
        if($this->isVendaOk()){
            $stmt = $this->conexao->prepare("SELECT COUNT[valor_pago] FROM pagamento WHERE nota_venda_FK=?");
            $stmt->bindParam(1, $this->venda);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $pagamentos = (int) $resultado['COUNT[valor_pago]'];
            
            if($pagamentos>0){
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}