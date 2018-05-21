<?php
include_once 'pagamento.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações relacionadas ao 
 * pagamento da venda no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class PagamentoDAO {
    /**
     * Variável que recebe o objeto da classe pagamento.
     * 
     * @access private
     * @var Object
     */
    private $pagamento;
    
    function __construct() {
        $this->pagamento = new Pagamento();
    }
    
    /**
     * Armazena as informações do pagamento no Banco de Dados.
     * 
     * @access public
     * @param int $venda
     * @param int $formaPagmto
     * @param double $valorPago
     * @param string $tipo
     * 
     * return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($venda, $formaPagmto, $valorPago){
        $this->pagamento->setVenda($venda);
        $this->pagamento->setForma($formaPagmto);
        $this->pagamento->setValor($valorPago);
        
        return $this->pagamento->salvar();
    }
    
    /**
     * Deleta do Banco de Dados as informações do pagamento.
     * Não poderá ser deletada do Banco de Dados o pagamento que já realizou algum
     * cadastro no Sistema.
     * 
     * @param int $id
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function remover($id){
        $this->pagamento->setId($id);
        
        return $this->pagamento->remover();
    }
    
    /**
     * Pesquisar os dados dos pagamentos no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos e suas informações.
     */
    public function obterTodos(){
        return $this->pagamento->obter();
    }
    
    /**
     * Pesquisar os dados do pagamento desejado no Banco de Dados.
     * 
     * @param int $id Código do pagamento desejado.
     * @return array[] Retorna uma lista de informações do pagamento desejado.
     */
    public function obterUnidade($id){
        $this->pagamento->setId($id);
        
        return $this->pagamento->obter();
    }
    
    /**
     * Pesquisar os dados dos pagamentos no Banco de Dados.
     * 
     * @access public
     * @param int $notaDeVenda Nota da venda desejada
     * @return array[] Retorna uma lista de pagamentos e suas informações.
     */
    public function obterPorNotaDeVenda($notaDeVenda){
        $this->pagamento->setVenda($notaDeVenda);
        
        return $this->pagamento->obter();
    }
    
    /**
    * Pesquisar os dados dos pagamentos de acordo com a forma de pagamento no Banco de Dados.
    * 
    * @access public
    * @param int $forma Código da forma de pagamento desejada
    * @return array[] Retorna uma lista de pagamentos e suas informações.
    */
    public function obterPorFormaDePagamento($forma){
        $this->pagamento->setForma($forma);
        
        return $this->pagamento->obter();
    }
    
    /**
    * Pesquisar os dados dos pagamentos de acordo com o tipo de pagamento no Banco de Dados.
    * 
    * @access public
    * @param string $tipo Tipo de pagamento desejada
    * @return array[] Retorna uma lista de pagamentos e suas informações.
    */
    public function obterPorTipoDePagamento($tipo){
        $this->pagamento->setForma($tipo);
        
        return $this->pagamento->obter();
    }
    
    /**
     * 
     * 
     * @return int Retorna o código do último pagamento.
     */
    public function obterIDUltimoPagamento(){
        return $this->pagamento->retornarUltimoPagamento();
    }
}