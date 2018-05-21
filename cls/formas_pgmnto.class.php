<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es relacionadas �s formas de 
 * pagamento da venda no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Formas_pgmnto {
    /** 
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /** 
     * Vari�vel que recebe o c�digo da forma de pagamento.
     *
     * @var string
     * @access private
     */
    private $id;
    
    /** 
     * Vari�vel que recebe a forma de pagamento.
     *
     * @var string
     * @access private
     */
    private $formas;
    
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
     * Armazena o c�digo da forma de pagamento na vari�vel.
     * 
     * @access public
     * @param string $valor C�digo da forma de pagamento.
     * @return void
     */
    public function setId($valor){
        $this->id = $valor;
    }
    
    /**
     * Armazena a forma de pagamento na vari�vel.
     * 
     * @access public
     * @param string $valor Forma de pagamento.
     * @return void
     */
    public function setFormas($valor){
        $this->formas = $valor;
    }
    
    /**
     * Confere se a vari�vel $id existe e tem valor maior que 0
     * 
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    public function isIdOk(){
        if(isset($this->id) && $this->id>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es da forma de pagamento no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar(){
        if(!empty($this->formas)){
            $stmt = $this->conexao->prepare("INSERT INTO formas_pgmnto VALUES('', ?)");
            $stmt->bindParam(1, $this->formas);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
     
    /**
     * Modifica as informa��es da forma de pagamento no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if ($this->isIdOk() && !empty($this->formas)){
            $stmt = $this->conexao->prepare("UPDATE formas_pgmnto SET forma_pgmnto=? WHERE id_forma_pgmto=?");
            $stmt->bindParam(1, $this->formas);
            $stmt->bindParam(2, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
   
    /**
     * Deleta do Banco de Dados as informa��es da forma de pagamento.
     * N�o poder� ser deletada do Banco de Dados a forma de pagamento 
     * que j� realizou algum cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isIdOk()){
            $stmt = $this->conexao->prepare("DELETE FROM formas_pgmnto WHERE id_forma_pgmto=?");
            $stmt->bindColumn(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados da(s) forma(s) de pagamento no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos de pend�ncias e suas informa��es.
     */
    public function obter(){
        $query = "SELECT id_forma_pgmto, forma_pgmnto FROM formas_pgmnto";
        if($this->isIdOk()){
            $query .= " WHERE id_forma_pgmnto=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
