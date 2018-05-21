<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es da compra do m�vel no Banco de Dados.
 * Uma compra est� relacionada diretamente a um m�vel espec�fico. S� � poss�vel 
 * realizar a compra de um m�vel espec�fico apenas uma vez por dia. Caso queira 
 * acrescentar m�veis no mesmo dia, pode alterar a quantidade atrav�s do bot�o "Alterar".
 * As informa��es relacionadas � compra do m�vel a serem armazenadas no Sistema:
 * c�digo da compra(gerado automaticamente), c�digo do m�vel, valor bruto,
 * data da compra e a quantidade de m�veis comprada.
 * Assim que a compra for conclu�da e armazenada no Banco de Dados, ter� sua
 * quantidade automaticamente somada no estoque.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Compra {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo da compra do m�vel no Sistema.
     * @access private
     * @var int
     */
    private $id;
    
    /**
     * Vari�vel que recebe o c�digo do m�vel no Sistema.
     * @access private
     * @var int
     */
    private $movel;
    
    /**
     * Vari�vel que recebe o valor bruto do m�vel no Sistema.
     * @access private
     * @var double
     */
    private $valor;
    
    /**
     * Vari�vel que recebe a data da compra do m�vel no Sistema.
     * @access private
     * @var string
     */
    private $data;
    
    /**
     * Vari�vel que recebe a quantidade do m�vel comprado no Sistema.
     * @access private
     * @var int
     */
    private $qtde;
    
    /**
     * Vari�vel que recebe a empresa fornecedora do m�vel comprado no Sistema.
     * @access private
     * @var string
     */
    private $empresa;
    
    /**
     * Inicia as opera��es da compra no Banco de Dados.
     * 
     * @return void
     */
    function __construct() {
        $this->conexao = Conexao::conectar();
        date_default_timezone_set('America/Recife');
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
     * Armazena o c�digo da compra do m�vel na vari�vel.
     * 
     * @access public
     * @param string $valor C�digo da compra do m�vel.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }
    
    /**
     * Armazena o c�digo do m�vel comprado.
     * 
     * @access public
     * @param string $valor C�digo do m�vel comprado.
     * @return void
     */
    public function setMovel($valor){
        $this->movel = $valor;
    }
    
    /**
     * Armazena o valor da compra do m�vel.
     * 
     * @access public
     * @param string $valor Valor da compra do m�vel.
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
     * Armazena a data da compra do m�vel.
     * 
     * @access public
     * @param string $valor Data da compra do m�vel.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Armazena quantidade de m�vel comprado.
     * 
     * @access public
     * @param int $qtde Data da compra do m�vel.
     * @return void
     */
    public function setQtde($qtde){
        $this->qtde = (int) $qtde;
    }
    
    /**
     * Armazena a empresa fornecedora.
     * 
     * @access public
     * @param string $valor Raz�o social da empresa fornecedora.
     * @return void
     */
    public function setEmpresa($valor){
        $this->empresa = $valor;
    }
    
    /**
     * Verifica se a vari�vel $qtde existe e tem valor maior que 0.
     * 
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE se n�o.
     */
    public function isVarOk($var){
        if(isset($this->$var) && ($this->$var > 0)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es da compra do m�vel no Banco de Dados.
     * 
     * @access public
     * @param int $idCompra C�digo da compra do M�vel no Sistema (DIGITE 0 PARA SALVAR).
     * @param int $idMovel C�digo do M�vel no Sistema.
     * @param double $valorCompra Valor pago pelo m�vel.
     * @param int $qtdeComprada Quantidade comprada.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($idCompra, $idMovel, $valorCompra, $qtdeComprada){
        $this->id = (int) $idCompra;
        $this->movel = (int) $idMovel;
        $this->valor = $valorCompra;
        $this->qtde = $qtdeComprada;
        
        if($this->isVarOk("id")){
            $stmt = $this->conexao->prepare("UPDATE compra SET id_movel_FK=?, valor_bruto=?, data_compra=?,qtde_compra=? WHERE id_compra=?");
            $stmt->bindParam(1, $this->movel);
            $stmt->bindParam(2, $this->valor);
            $stmt->bindParam(3, $this->data);
            $stmt->bindParam(4, $this->qtde);
            $stmt->bindParam(5, $this->id);

            return $stmt->execute();
        } elseif(strcmp($this->obterDataUltimaCompra(), date('Y-m-d'))!==0) {
            $stmt = $this->conexao->prepare("INSERT INTO compra VALUES ('', ?, ?, ?, ?)");
            $stmt->bindParam(1, $this->movel);
            $stmt->bindParam(2, $this->valor);
            $stmt->bindParam(3, date('Y-m-d'));
            $stmt->bindParam(4, $this->qtde);

            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta do Banco de Dados as informa��es da compra do m�vel selecionado.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($id){
        $this->id = (int) $id;
        
        if($this->isVarOk("id")){
            $stmt = $this->conexao->prepare("DELETE FROM compra WHERE id_compra=?");
            $stmt->bindParam(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados da(s) compra(s) do(s) m�vel(eis) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informa��es da(s) empresa(s)
     */
    public function obter(){
        $query = "SELECT a.id_compra, a.data_compra, a.valor_bruto, a.qtde_compra,"
                . " b.modelo, b.tipo, c.empresa, c.representante FROM compra a,"
                . " movel b, fabricante c WHERE a.id_movel_FK=b.id_movel and"
                . " b.id_fabricante_FK=c.id_fabricante";
        if($this->isVarOk("id")){
            $query .= " AND a.id_compra=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif($this->isVarOk("movel")){
            $movel = "%" . $this->movel . "%" ;
            $query .= " AND a.id_movel_FK LIKE ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->movel);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->data)){
            $query .= " AND a.data_compra=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->data);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->empresa)){
            $empresa = "%" . $this->empresa . "%";
            $query .= " AND c.empresa LIKE ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $empresa);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        }
    }
    
    public function obterPorMoveis($modelo){
        $aux = "%" . $modelo . "%";
        $query = "SELECT a.id_compra, a.data_compra, a.valor_bruto, a.qtde_compra,"
                . " b.modelo, b.tipo, c.empresa, c.representante FROM compra a,"
                . " movel b, fabricante c WHERE a.id_movel_FK=b.id_movel and"
                . " b.id_fabricante_FK=c.id_fabricante AND b.modelo LIKE ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $aux);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obterPorIntervaloDeDatas($data1, $data2){
        if($data1>$data2){
            $aux = $data1;
            $data1 = $data2;
            $data2 = $aux;
        }
        
        $query = "SELECT a.id_compra, a.data_compra, a.valor_bruto, a.qtde_compra,"
                . " b.modelo, b.tipo, c.empresa, c.representante FROM compra a,"
                . " movel b, fabricante c WHERE a.id_movel_FK=b.id_movel and"
                . " b.id_fabricante_FK=c.id_fabricante AND a.data_compra BETWEEN ? AND ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $data1);
        $stmt->bindParam(2, $data2);
        $stmt->execute();

        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna a data da �ltima compra. Se um m�vel for selecionado, 
     * ser� a �ltima data da compra do mesmo.
     * 
     * @access private
     * @return string Retorna a data da �ltima compra
     */
    private function obterDataUltimaCompra(){
        $query = "SELECT max(data_compra) FROM compra";
        if(isset($this->movel)){    //data da �ltima compra do m�vel selecionado
            $query .= " WHERE id_movel_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->movel);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $resultado['max(data_compra)'];
        } else {    //data da �ltima compra
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $resultado['max(data_compra)'];
        }
    }
    
    /**
     * Retorna as informa��es da �ltima compra. Se um m�vel for selecionado, 
     * ser� a �ltima data da compra do mesmo.
     * 
     * @access public
     * @return array[] Retorna a(s) �ltima(s) compra(s)
     */
    public function obterUltimaCompraProduto(){
        $query = "SELECT a.id_compra, b.id_movel, b.modelo, a.valor_bruto,"
                . " b.valor_venda, a.data_compra FROM compra a, movel b"
                . " WHERE a.id_movel_FK=b.id_movel AND"
                . " data_compra=(SELECT MAX(data_compra) FROM compra";
        if(isset($this->movel)){
            $query .= " WHERE id_movel_FK=?) AND a.id_movel_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->movel);
            $stmt->bindParam(2, $this->movel);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $query .= ")";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $this->obterDataUltimaCompra());
        $stmt->execute();
        
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
}