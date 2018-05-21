<?php
include_once 'venda.class.php';

/**
 * Classe relacionada �s opera��es relacionadas �s vendas dos m�veis.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class VendaDAO{
    /**
     * Vari�vel que recebe o objeto da classe Venda.
     *
     * @access private
     * @var Object 
     */
    private $venda;
    
    function __construct() {
        $this->venda = new Venda();
    }
    
    /**
     * Armazena as informa��es da venda no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($cliente, $vendedor, $desconto, $total, $situacao){
        $this->venda->setCliente($cliente);
        $this->venda->setVendedor($vendedor);
        $this->venda->setDesconto($desconto);
        $this->venda->setTotal($total);
        $this->venda->setSituacao($situacao);
        
        return $this->venda->salvar();
    }
    
    /**
     * Retorna a nota de venda da �ltima venda registrada.
     * 
     * @return array
     */
    public function obterNotaUltimaVenda(){
        return $this->venda->obterUltimaVenda();
    }
    
    /**
     * Retorna lita de informa��es das vendas
     * 
     * @return array
     */
    public function obterTodos(){
        return $this->venda->obter();
    }
    
    /**
     * Retorna informa��es sobre as �ltimas notas de vendas lan�adas por clientes.
     * 
     * @return array
     */
    public function obterUltimasNotasDeVendasPorClientes($cliente){
        return $this->venda->obterUltimasNotasDeVendasPorCliente($cliente);
    }
    
    /**
     * Retorna informa��es da venda selecionada
     * 
     * @param int $notaVenda Nota da venda selecionada.
     * @return array
     */
    public function obterPorNotaDeVenda($notaVenda){
        $this->venda->setNota($notaVenda);
        
        return $this->venda->obter();
    }
    
    /**
     * Retorna as informa��es da venda de acordo com a data.
     * 
     * @param date $data Data desejada.
     * @return array
     */
    public function obterPorData($data){
        $this->venda->setData($data);
        
        return $this->venda->obter();
    }
    
    /**
     * Retorna a quantidade de vendas realizadas por cada vendedor e o total recebido pelos mesmos por cada per�odo de tempo.
     * 
     * @param date $data1 Data inicial.
     * @param date $data2 Data final.
     * @return array
     */
    public function listarPorVendedor($data1, $data2){
        return $this->venda->listarPorVendedor($data1, $data2);
    }
    
    public function obterUltimaNotaPorCliente($cpf){
        $this->venda->setCliente($cpf);
        
        return $this->venda->obterUltimaVendaPorCliente();
    }
    
    /**
     * Retorna as informa��es da venda de acordo com o per�odo desejado.
     * 
     * @param date $data1 Data inicial.
     * @param date $data2 Data final.
     * @return array
     */
    public function obterPorIntervaloDatas($data1, $data2){
        return $this->venda->pesquisarPorIntervaloDeDatas($data1, $data2);
    }
    
    /**
     * Confere se o c�digo de venda citado existe ou n�o.
     * 
     * @access public
     * @param int $nota C�digo da nota de venda.
     * @return boolean Retorna TRUE se o c�digo de venda existe e FALSE se n�o existe venda com o c�digo citado.
     */
    public function confereNotaDeVenda($nota){
        $this->venda->setNota($nota);
        
        return $this->venda->verificarVenda();
    }
    
    /**
     * Retorna as formas de pagamento das vendas desejadas.
     * 
     * @return array
     */
    public function obterFormasDePagamentos(){
        return $this->venda->obterFormasPagamento();
    }
    
    /**
     * Retorna as formas de pagamento das vendas desejadas.
     * 
     * @param date $data Data desejada
     * @return array
     */
    public function obterFormasDePagamentosPorDia($data){
        $this->venda->setData($data);
        
        return $this->venda->obterFormasPagamento();
    }
    
    /**
     * Retorna as formas de pagamento das vendas desejadas.
     * 
     * @param date $data1 Data inicial.
     * @param date $data2 Data final.
     * @return array
     */
    public function obterFormasDePagamentoPorPeriodo($data1, $data2){
        return $this->venda->obterFormasPagamentoPorPeriodo($data1, $data2);
    }
}