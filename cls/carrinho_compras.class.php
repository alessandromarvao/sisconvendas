<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es dos carrinhos de compras no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Carrinho_compras {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var PDO
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o CPF do cliente.
     *
     * @var string
     */
    private $cliente;
    
    /**
     * Vari�vel que recebe o c�digo do m�vel.
     *
     * @var int
     */
    private $movel;
    
    /**
     * Vari�vel que recebe a quantidade do m�vel desejada.
     *
     * @var int
     */
    private $qtde;
    
    /**
     * Vari�vel que recebe o valor do m�vel.
     *
     * @var double
     */
    private $valorUnitario;
    
    /**
     * Vari�vel que recebe a confirma��o da entrega do m�vel.
     *
     * @var int
     */
    private $entrega;
    
    /**
     * Vari�vel que recebe a data da entrega do m�vel.
     *
     * @var date
     */
    private $dataEntrega;
    
    /**
     * Vari�vel que recebe a confirma��o da montagem do m�vel.
     *
     * @var int
     */
    private $montagem;
    
    /**
     * Vari�vel que recebe a data da montagem do m�vel.
     *
     * @var date
     */
    private $dataMontagem;
    
    /**
     * Inicia as opera��es relacionadas � tabela carrinho_compras do BD.
     */
    function __construct() {
        $this->conexao = Conexao::conectar();
    }
    
    public function __get($nome){
        return $this->$nome;
    }
    
    /**
     * Armazena o valor desejado na vari�vel local CLIENTE.
     * 
     * @access public
     * @param string $valor
     */
    public function setCliente($valor){
        $this->cliente = $valor;
    }
    
    /**
     * Armazena o valor desejado na vari�vel local MOVEL.
     * 
     * @access public
     * @param int $valor
     */
    public function setMovel($valor){
        $this->movel = $valor;
    }
    
    /**
     * Armazena o valor desejado na vari�vel local QTDE.
     * 
     * @access public
     * @param int $valor
     */
    public function setQtde($valor){
        $this->qtde = (int) $valor;
    }
  
    /**
     * Armazena o valor desejado na vari�vel local VALORUNITARIO.
     * 
     * @access public
     * @param double $valor
     */
    public function setValor($valor){
        $lista = explode(",", $valor);
        $string = implode(".", $lista);
        $numero = (double) $string;
        $final = number_format($numero,2,".","");
        
        $this->valorUnitario = $final;
    }
    
    /**
     * Armazena o valor desejado na vari�vel local ENTREGA.
     * 
     * @access public
     * @param int $valor
     */
    public function setEntrega($valor){
        $this->entrega = (int) $valor;
    }
    
    /**
     * Armazena o valor desejado na vari�vel local montagem.
     * 
     * @access public
     * @param int $valor
     */
    public function setMontagem($valor){
        $this->montagem = (int) $valor;
    }
    
    /**
     * Confere se a vari�vel CLIENTE n�o est� vazia.
     * 
     * @access public
     * @return boolean Retorna TRUE se a condi��o for aceita e FALSE se n�o.
     */
    private function isClienteOk(){
        if(!empty($this->cliente)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel MOVEL n�o est� vazia e � diferente de 0.
     * 
     * @access public
     * @return boolean Retorna TRUE se a condi��o for aceita e FALSE se n�o.
     */
    private function isMovelOk(){
        if(!empty($this->movel) && $this->movel!==0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel QTDE n�o est� vazia e � diferente de 0.
     * 
     * @access public
     * @return boolean Retorna TRUE se a condi��o for aceita e FALSE se n�o.
     */
    private function isQtdeOk(){
        if(!empty($this->qtde) && $this->qtde!==0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel VALORUNITARIO n�o est� vazia e � diferente de 0.
     * 
     * @access public
     * @return boolean Retorna TRUE se a condi��o for aceita e FALSE se n�o.
     */
    private function isValorOk(){
        if(!empty($this->valorUnitario) && $this->valorUnitario!==0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena no Banco de Dados as informa��es do carrinho de compras selecionado.
     * 
     * @access public
     * @param string $cliente CPF do cliente desejado.
     * @param int $movel C�digo do m�vel desejado.
     * @param int $qtde Quantidade comprada.
     * @param double $valor Valor unit�rio do m�vel desejado.
     * @param int $montagem 1 para positivo e 0 para negativo.
     * @param date $dataMontagem Data da montagem do(s) m�vel(is).
     * @param int $entrega 1 para positivo e 0 para negativo.
     * @param date $dataEntrega Data da entrega do(s) m�vel(is).
     * @return boolean return TRUE se a opera��o ocorrer com sucesso e FALSE se ocorrer alguma falha.
     */
    public function salvar($cliente, $movel, $qtde, $valor, $montagem, $dataMontagem, $entrega, $dataEntrega){
        $this->cliente = $cliente;
        $this->movel = $movel;
        $this->qtde = $qtde;
        $this->valorUnitario = $valor;
        $this->montagem = $montagem;
        $this->dataMontagem = $dataMontagem;
        $this->entrega = $entrega;
        $this->dataEntrega = $dataEntrega;
        
        if($this->isClienteOk() && $this->isMovelOk() && $this->isQtdeOk() && $this->isValorOk() && isset($this->entrega) && isset($this->montagem)){
            $stmt = $this->conexao->prepare("INSERT INTO carrinho_compras (cpf_cliente_FK, id_movel_FK, qtde_carrinho, valor_unidade, montagem, data_montagem, entrega, data_entrega) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1, $this->cliente);
            $stmt->bindParam(2, $this->movel);
            $stmt->bindParam(3, $this->qtde);
            $stmt->bindParam(4, $this->valorUnitario);
            if(empty($this->montagem)){
                $this->montagem = 0;
                $this->dataMontagem = NULL;
            }
            $stmt->bindParam(5, $this->montagem);
            $stmt->bindParam(6, $this->dataMontagem);
            if(empty($this->entrega)){
                $this->entrega = 0;
                $this->dataEntrega = NULL;
            }
            $stmt->bindParam(7, $this->entrega);
            $stmt->bindParam(8, $this->dataEntrega);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Altera no Banco de Dados as informa��es do carrinho de compras selecionado.
     * 
     * @access public
     * @param string $cliente CPF do cliente desejado.
     * @param int $movel C�digo do m�vel desejado.
     * @param int $qtde Quantidade comprada.
     * @param double $valor Valor unit�rio do m�vel desejado.
     * @param int $montagem 1 para positivo e 0 para negativo.
     * @param int $entrega 1 para positivo e 0 para negativo.
     * @return boolean return TRUE se a operação ocorrer com sucesso e FALSE se ocorrer alguma falha.
     */
    public function alterar($cliente, $movel, $qtde, $valor, $montagem, $dataMontagem, $entrega, $dataEntrega){
        $this->cliente = $cliente;
        $this->movel = $movel;
        $this->qtde = $qtde;
        $this->valorUnitario = $valor;
        $this->montagem = $montagem;
        $this->dataMontagem = $dataMontagem;
        $this->entrega = $entrega;
        $this->dataEntrega = $dataEntrega;
        
        $query = "UPDATE carrinho_compras SET qtde_carrinho=?, valor_unidade=?, montagem=?, data_montagem=?, entrega=?, data_entrega=? WHERE cpf_cliente_FK=? AND id_movel_FK=?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $this->qtde);
        $stmt->bindParam(2, $this->valorUnitario);
        $stmt->bindParam(3, $this->montagem);
        $stmt->bindParam(4, $this->dataMontagem);
        $stmt->bindParam(5, $this->entrega);
        $stmt->bindParam(6, $this->dataEntrega);
        $stmt->bindParam(7, $this->cliente);
        $stmt->bindParam(8, $this->movel);

        return $stmt->execute();
    }
    
    /**
     * Deleta no Banco de Dados as informa��es do carrinho de compras selecionado.
     * 
     * @access public
     * @param string $cliente CPF do cliente.
     * @param int $movel C�digo do m�vel no Banco de Dados.
     * @return boolean return TRUE se a opera��o ocorrer com sucesso e FALSE se ocorrer alguma falha.
     */
    public function remover($cliente, $movel){
        $this->cliente = $cliente;
        $this->movel = $movel;
        
        $stmt = $this->conexao->prepare("DELETE FROM carrinho_compras WHERE cpf_cliente_FK=? AND id_movel_FK=?");
        $stmt->bindParam(1, $this->cliente);
        $stmt->bindParam(2, $this->movel);

        return $stmt->execute();
    }
    
    /**
     * Deleta no Banco de Dados as informa��es dos carrinhos de compras do cliente em quest�o.
     * 
     * @param type $cliente
     * @return boolean return TRUE se a opera��o ocorrer com sucesso e FALSE se ocorrer alguma falha.
     */
    public function removerPorCliente($cliente){
        $i=0;
        $qtde = count($this->obter());
        
        foreach ($this->obter() as $linha) {
            if($this->remover($cliente, $linha['id_movel_FK'])) {
                $i++;
            }
        }
        
        if($i==$qtde){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna as informa��es do carrinho de compras selecionado no Banco de Dados.
     * 
     * @access public
     * @return array Retorna as informa��es do carrinho de compras selecionado no Banco de Dados.
     */
    public function obter(){
        $query = "SELECT a.cpf_cliente_FK, a.id_movel_FK, b.modelo, a.qtde_carrinho,"
                . " a.valor_unidade, a.entrega, a.data_entrega, a.montagem, a.data_montagem FROM carrinho_compras a, movel b"
                . " WHERE a.id_movel_FK=b.id_movel";
        if($this->isClienteOk()){
            $query .= " AND cpf_cliente_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cliente);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif($this->isMovelOk()){
            $query .= " AND id_movel_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->movel);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}