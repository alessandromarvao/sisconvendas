<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es de venda no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Venda {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo da nota de venda.
     * 
     * @access private
     * @var int
     */
    private $nota;
    
    /**
     * Vari�vel que recebe o c�digo do cliente.
     * 
     * @access private
     * @var string
     */
    private $cliente;
    
    /**
     * Vari�vel que recebe o c�digo do vendedor.
     * 
     * @access private
     * @var string
     */
    private $vendedor;
    
    /**
     * Vari�vel que recebe a data da venda.
     * 
     * @access private
     * @var string
     */
    private $data;
    
    /**
     * Vari�vel que recebe a hora da venda.
     * 
     * @access private
     * @var string
     */
    private $hora;
    
    /**
     * Vari�vel que recebe o valor do desconto na venda.
     * 
     * @access private
     * @var double
     */
    private $desconto;
    
    /**
     * Vari�vel que recebe o valor total da venda.
     * 
     * @access private
     * @var double
     */
    private $total;
    
    /**
     * Vari�vel que recebe a situa��o da venda (conclu�da ou cancelada).
     * 
     * @access private
     * @var string
     */
    private $situacao;
    
    /**
     * Inicia as opera��es no BD.
     * 
     * @return void
     */
    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectar();
        
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
     * Armazena o c�digo da nota de venda na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da nota de venda.
     * @return void
     */
    public function setNota($valor){
        $this->nota = (int) $valor;
    }
    
    /**
     * Armazena o c�digo do cliente na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo do cliente.
     * @return void
     */
    public function setCliente($valor){
        $this->cliente = $valor;
    }
    
    /**
     * Armazena o CPF do vendedor na vari�vel.
     * 
     * @access public
     * @param string $valor CPF do vendedor.
     * @return void
     */
    public function setVendedor($valor){
        $this->vendedor = $valor;
    }
    
    /**
     * Armazena a data da venda na vari�vel.
     * 
     * @access public
     * @param string $valor Data da venda.
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Armazena o c�digo da hora da venda na vari�vel.
     * 
     * @access public
     * @param string $valor C�digo da hora da venda.
     * @return void
     */
    public function setHora($valor){
        $this->hora = $valor;
    }
    
    /**
     * Armazena o c�digo do desconto na vari�vel.
     * 
     * @access public
     * @param double $valor C�digo do desconto.
     * @return void
     */
    public function setDesconto($valor){
        $this->desconto = (double) $valor;
    }
    
    /**
     * Armazena o c�digo do valor total na vari�vel.
     * 
     * @access public
     * @param double $valor C�digo do valor total da venda.
     * @return void
     */
    public function setTotal($valor){
        $this->total = (double) $valor;
    }
    
    /**
     * Armazena o c�digo da situa��o da venda na vari�vel.
     * 
     * @access public
     * @param string $valor Situa��o da venda (conclu�da ou cancelada).
     * @return void
     */
    public function setSituacao($valor){
        $this->situacao = $valor;
    }
    
    /**
     * Confere se a vari�vel $nota existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isNotaOk(){
        if(isset($this->nota) && $this->nota !== 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $cliente existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isClienteOk(){
        if(isset($this->cliente)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $vendedor existe e tem valor maior que 0.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isVendedorOk(){
        if(isset($this->vendedor)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $desconto existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isDescontoOk(){
        if(isset($this->desconto)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $total existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isTotalOk(){
        if(isset($this->total)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Confere se a vari�vel $situacao existe.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida
     * e FALSE se n�o for.
     */
    private function isSituacaoOk(){
        if(!empty($this->situacao)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es da venda no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar(){
        if($this->isClienteOk() && $this->isVendedorOk() && $this->isDescontoOk() && $this->isTotalOk() && $this->isSituacaoOk()){
            $aux = "(cpf_cliente_FK, login_FK, data, hora, desconto, valor_total, situacao)"; //Parâmetros a serem alterados
            $stmt = $this->conexao->prepare("INSERT INTO venda ". $aux . " VALUES ( ?, ?, ?, ?, ?, ?, ?)");
            $data = date('Y-m-d');
            $hora = date('H:i:s');
            $stmt->bindParam(1, $this->cliente);
            $stmt->bindParam(2, $this->vendedor);
            $stmt->bindParam(3, $data);
            $stmt->bindParam(4, $hora);
            $stmt->bindParam(5, $this->desconto);
            $stmt->bindParam(6, $this->total);
            $stmt->bindParam(7, $this->situacao);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informa��es da venda no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar(){
        if($this->isNotaOk() && $this->isClienteOk() && $this->isVendedorOk() && $this->isDescontoOk() && $this->isTotalOk() && $this->isSituacaoOk()){
            $query = "UPDATE venda SET cpf_cliente_FK=?, login_FK=?, data=?, hora=?, desconto=?, valor_total=?, situacao=? WHERE nota_venda=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cliente);
            $stmt->bindParam(2, $this->vendedor);
            $stmt->bindParam(3, $this->data);
            $stmt->bindParam(4, $this->hora);
            $stmt->bindParam(5, $this->desconto);
            $stmt->bindParam(6, $this->total);
            $stmt->bindParam(7, $this->situacao);
            $stmt->bindParam(8, $this->nota);
            
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
        if($this->isNotaOk()){
            $stmt = $this->conexao->prepare("DELETE FROM venda WHERE nota_venda=?");
            $stmt->bindParam(1, $this->nota);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados da(s) venda(s) no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de vendas e suas informa��es. 
     * Caso especificar um cliente ou vendedor, retorna a lista de informa��es
     * relacionadas aos mesmos.
     */
    public function obter(){
        $query = "SELECT a.nota_venda, a.cpf_cliente_FK, b.login_FK, b.nome, a.data, a.hora,"
                . " a.desconto, a.valor_total, a.situacao, c.nome_cliente, c.tel_cliente, c.cel1_cliente, c.cel2_cliente FROM venda a,"
                . " usuario b, cliente c WHERE a.login_FK=b.login_FK AND a.cpf_cliente_FK=c.cpf_cliente";
        if($this->isNotaOk()){  //pesquisar por nota de venda
            $query .= " AND nota_venda=? ORDER BY a.nota_venda";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->nota);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif($this->isClienteOk()){ //pesquisar por cliente
            $query .= " AND cpf_cliente_FK=? ORDER BY a.nota_venda DESC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cliente);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif($this->isVendedorOk()){    //pesquisar por vendedor
            $query .= " AND cpf_cliente_FK=? ORDER BY a.nota_venda";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cliente);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(!empty($this->data)){  //pesquisar por data da venda
            $query .= " AND data=? ORDER BY a.nota_venda";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->data);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif($this->isSituacaoOk()){    //pesquisar por situa��o
            $query .= " AND situacao=? ORDER BY a.nota_venda";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->situacao);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else{ //pesquisar todos
            $query .= " ORDER BY c.nome_cliente ASC, a.nota_venda DESC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Lista as vendas por vendedor.
     * 
     * @param date $data1
     * @param date $data2
     * @return array
     */
    public function listarPorVendedor($data1, $data2){
        if(!empty($data1) && !empty($data2)){
            if(strcmp($data1, $data2)>0){
                $aux = $data1;
                $data1 = $data2;
                $data2 = $aux;
            }
            $query = "SELECT COUNT(a.nota_venda) as vendas, SUM(a.valor_total) as total,"
                    . " b.nome, b.cpf FROM venda a, usuario b WHERE a.login_FK=b.login_FK";
            if(isset($this->vendedor)){
                $query .= " AND b.login_FK=? AND a.data BETWEEN ? AND ? GROUP BY b.nome ASC";
                $stmt = $this->conexao->prepare($query);
                $stmt->bindParam(1, $this->vendedor);
                $stmt->bindParam(2, $data1);
                $stmt->bindParam(3, $data2);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $query .= " AND a.data BETWEEN ? AND ? GROUP BY b.nome ASC";
                $stmt = $this->conexao->prepare($query);
                $stmt->bindParam(1, $data1);
                $stmt->bindParam(2, $data2);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    }
    
    /**
     * Pesquisar por vendas ocorridas em um determidado per�odo de tempo.
     * 
     * @param string $data1 Data inicial
     * @param string $data2 Data final
     * @return array[] Retorna lista de vendas ocorridas em um determidado per�odo de tempo.
     */
    public function pesquisarPorIntervaloDeDatas($data1, $data2){
        if(!empty($data1) && !empty($data2)){
            if(strcmp($data1, $data2)>0){
                $aux = $data1;
                $data1 = $data2;
                $data2 = $aux;
            }
            
            $query = "SELECT a.nota_venda, a.cpf_cliente_FK, b.login_FK, b.nome, a.data, a.hora,"
                    . " a.desconto, a.valor_total, a.situacao FROM venda a, usuario b"
                    . " WHERE a.login_FK=b.login_FK AND data BETWEEN ? AND ?";
            
            if($this->isClienteOk()){   //pesquisar por cliente
                $query .= " AND cpf_cliente_FK=?";
                $stmt = $this->conexao->prepare($query);
                $stmt->bindParam(1, $data1);
                $stmt->bindParam(2, $data2);
                $stmt->bindParam(3, $this->cliente);
                $stmt->execute();
                
                return $stmt->fetchALL(PDO::FETCH_ASSOC);
            } elseif($this->isVendedorOk()){    //pesquisar por vendedor
                $query .= " AND login_FK=?";
                $stmt = $this->conexao->prepare($query);
                $stmt->bindParam(1, $data1);
                $stmt->bindParam(2, $data2);
                $stmt->bindParam(3, $this->vendedor);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $stmt = $this->conexao->prepare($query);
                $stmt->bindParam(1, $data1);
                $stmt->bindParam(2, $data2);
                $stmt->execute();
                
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }else {
            return NULL;
        }
    }
    
    public function obterUltimaVendaPorCliente(){
        if($this->isClienteOk()){
            $query = "SELECT MAX(nota_venda) as nota from venda where cpf_cliente_FK=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cliente);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC)['nota'];
        } else {
            return NULL;
        }
    }
    
    /**
     * Retorna a �ltima nota de venda de acordo com o CPF do cliente.
     * 
     * @return array
     */
    public function obterUltimaVenda(){
        $stmt = $this->conexao->prepare("SELECT max(nota_venda) FROM venda");
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['max(nota_venda)'];
    }
    
    /**
     * Confere se o c�digo de venda citado existe ou n�o.
     * 
     * @return boolean Retorna TRUE se o c�digo de venda existe e FALSE se n�o existe venda com o c�digo citado.
     */
    public function verificarVenda(){
        if($this->isNotaOk()){
            $stmt = $this->conexao->prepare("select count(data) from venda where nota_venda=?");
            $stmt->bindParam(1, $this->nota);
            $stmt->execute();
            $aux = $stmt->fetch(PDO::FETCH_ASSOC);
            $resultado = (int) $aux['count(data)'];
            if($resultado==1){
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna as formas de pagamento das vendas desejadas.
     * 
     * @return array
     */
    public function obterFormasPagamento(){
        $query  = "SELECT a.forma_pgmnto, sum(b.valor_pago) as total"
                . " FROM formas_pgmnto a, pagamento b, venda c WHERE"
                . " b.nota_venda_FK=c.nota_venda AND b.id_forma_pgmto_FK=a.id_forma_pgmto";
        if(isset($this->data)){
            $query .= " AND c.data=? GROUP BY a.forma_pgmnto";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->data);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else{
            $query .= " GROUP BY a.forma_pgmnto";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna as formas de pagamento das vendas desejadas.
     * 
     * @param date $data1 Data inicial
     * @param date $data2 Data final
     * @return array
     */
    public function obterFormasPagamentoPorPeriodo($data1, $data2){
        if($data1>$data2){
            $aux = $data1;
            $data1 = $data2;
            $data2 = $aux;
        }
        $query  = "SELECT a.forma_pgmnto, sum(b.valor_pago) as total"
                . " FROM formas_pgmnto a, pagamento b, venda c WHERE"
                . " b.nota_venda_FK=c.nota_venda AND b.id_forma_pgmto_FK=a.id_forma_pgmto AND c.data BETWEEN ? AND ? GROUP BY a.forma_pgmnto";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $data1);
        $stmt->bindParam(2, $data2);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna informa��es sobre as �ltimas notas de vendas lan�adas por clientes.
     * 
     * @return array
     */
    public function obterUltimasNotasDeVendasPorCliente($cliente=''){
        $query = "SELECT a.nome_cliente AS nome, a.cpf_cliente AS cpf, MAX(b.nota_venda) AS nota, b.data, b.valor_total"
                . " FROM cliente a, venda b";
        if(!empty($cliente)){
            $cliente = "%" . $cliente . "%";
            $query .= " WHERE a.nome_cliente LIKE ? AND a.cpf_cliente=b.cpf_cliente_FK GROUP BY a.nome_cliente";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $cliente);
        } else {
            $query .= " WHERE a.cpf_cliente=b.cpf_cliente_FK GROUP BY a.nome_cliente";
            $stmt = $this->conexao->prepare($query);
            
        }
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}