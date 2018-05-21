<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es de venda de um m�vel espec�fico
 * no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Movel_possui_venda {
    /* Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
    *
    * @var Object
    * @access private
    */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo da venda do m�vel.
     * 
     * @access private
     * @var int
     */
    private $id;


    /**
     * Vari�vel que recebe o c�digo do m�vel.
     * 
     * @access private
     * @var int
     */
    private $movel;
    
    /**
     * Vari�vel que recebe o c�digo da nota de venda.
     * 
     * @access private
     * @var int
     */
    private $venda;
    
    /**
     * Vari�vel que recebe a quantidade do m�vel a ser comprado.
     * 
     * @access private
     * @var int
     */
    private $qtde;
    
    /**
     * Vari�vel que recebe o valor da venda do m�vel espec�fico.
     * 
     * @access private
     * @var double
     */
    private $valor;
    
    /**
     * Vari�vel que recebe a condi��o de entrega (1=SIM e 0=N�O)
     *
     * @access public
     * @var int 
     */
    private $entrega;
    
    /**
     * Vari�vel que recebe a condi��o de montagem (1=SIM e 0=N�O)
     *
     * @access public
     * @var int 
     */
    private $montagem;


    /**
     * Inicia as opera��es de autentica��o do Usu�rio do Sistema no BD.
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
     * Armazena o c�digo da venda do m�vel selecionado na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da venda do m�vel.
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
     * Armazena o c�digo do m�vel na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo do m�vel.
     * @return void
     */
    public function setMovel($valor){
        $this->movel = (int) $valor;
    }
    
    /**
     * Armazena a quantidade do m�vel especificado na vari�vel.
     * 
     * @access public
     * @param int $valor Quantidade do m�vel.
     * @return void
     */
    public function setQtde($valor){
        $this->qtde = (int) $valor;
    }
    
    /**
     * Armazena a quantidade do m�vel especificado na vari�vel.
     * 
     * @access public
     * @param double $valor Quantidade do m�vel.
     * @return void
     */
    public function setValor($valor){
        $lista = explode(",", $valor);
        $string = implode(".", $lista);
        $num = (double) $string;
        $preco = number_format($num,2,".","");
        $this->valor = $preco;
    }
    
    /**
     * Armazena a condi��o de entrega(0=N�O e 1=SIM).
     * 
     * @access public
     * @param double $valor Condi��o de entrega(0=N�O e 1=SIM).
     * @return void
     */
    public function setEntrega($valor){
        $this->entrega = (int) $valor;
    }
    
    /**
     * Armazena a condi��o de montagem(0=N�O e 1=SIM).
     * 
     * @access public
     * @param double $valor Condi��o de montagem(0=N�O e 1=SIM).
     * @return void
     */
    public function setMontagem($valor){
        $this->montagem = (int) $valor;
    }
    
    /**
     * Confere se a vari�vel $id existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    public function isIdOk(){
        if(isset($this->id) && $this->id>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $movel existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isMovelOk(){
        if(isset($this->movel) && $this->movel > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $venda existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isVendaOk(){
        if(isset($this->venda) && $this->venda > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $qtde existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isQtdeOk(){
        if(isset($this->qtde) && $this->qtde > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $valor existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isValorOk(){
        if(isset($this->valor)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $entrega existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isEntregaOk(){
        if(isset($this->entrega)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $montagem existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isMontagemOk(){
        if(isset($this->montagem)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es relacionadas � venda do 
     * m�vel espec�fico no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar(){
        if($this->isMovelOk() && $this->isVendaOk() && $this->isValorOk() && $this->isQtdeOk() && $this->isEntregaOk() && $this->isMontagemOk()){
            $aux = "(id_movel_FK, nota_venda_FK, qtde, valor_liquido, entrega, montagem)";
            $stmt = $this->conexao->prepare("INSERT INTO movel_possui_venda " . $aux . " VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->movel);
            $stmt->bindParam(2, $this->venda);
            $stmt->bindParam(3, $this->qtde);
            $stmt->bindParam(4, $this->valor);
            $stmt->bindParam(5, $this->entrega);
            $stmt->bindParam(6, $this->montagem);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informa��es da venda 
     * de um m�vel espec�fico no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isMovelOk() && $this->isVendaOk() && $this->isValorOk() && $this->isQtdeOk()){
            $stmt = $this->conexao->prepare("UPDATE movel_possui_venda SET qtde=?,"
                    . " valor_liquido=? WHERE id_movel_FK=? AND nota_venda_FK=?)");
            $stmt->bindParam(1, $this->qtde);
            $stmt->bindParam(2, $this->valor);
            $stmt->bindParam(3, $this->movel);
            $stmt->bindParam(4, $this->venda);
            $stmt->bindParam(4, $this->entrega);
            $stmt->bindParam(4, $this->montagem);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta do Banco de Dados as informa��es da venda.
     * N�o poder� ser deletada do Banco de Dados a venda que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isMovelOk() && $this->isVendaOk()){
            $stmt = $this->conexao->prepare("DELETE FROM movel_possui_venda WHERE id_movel_possui_venda=?");
            $stmt->bindParam(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados relacionados �(s) venda(s) do(s) m�vel(eis) no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de vendas e suas informa��es.
     */
    public function obter(){
        $query = "SELECT b.id_movel, b.modelo, a.id_movel_possui_venda, a.nota_venda_FK, a.qtde,"
                . " a.valor_liquido, a.entrega, a.montagem, b.tipo, c.empresa"
                . " FROM movel_possui_venda a, movel b, fabricante c WHERE b.id_fabricante_FK=c.id_fabricante"
                . " AND a.id_movel_FK=b.id_movel";
        if(isset($this->movel)){
            $query .= " AND a.id_movel_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->movel);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($this->isIdOk()){
            $query .= " AND a.id_movel_possui_venda=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->venda)){
            $query .= " AND a.nota_venda_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->venda);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna o c�digo da �ltima venda de m�vel.
     * 
     * @return int C�digo da �ltima venda de m�vel.
     */
    public function obterUltimoRegistro(){
        $stmt = $this->conexao->prepare("SELECT max(id_movel_possui_venda) FROM movel_possui_venda");
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['max(id_movel_possui_venda)'];
    } 
}