<?php
include_once 'parcelas.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações relacionadas ao pagamento das parceças no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class ParcelasDAO {
    /**
     * Variável que recebe o objeto da classe parcela.
     * 
     * @access private
     * @var Object
     */
    private $parcela;
    
    function __construct() {
        $this->parcela = new Parcelas();
    }
    
    /**
     * Armazena as informações do pagamento parcelado no Banco de Dados.
     * 
     * @access public
     * @param int $pagamento
     * @param int $qtde
     * @param double $valorDasParcelas
     */
    public function salvar($pagamento, $qtde, $valorDasParcelas){
        $this->parcela->setPagamento($pagamento);
        $this->parcela->setQtdeParcelas($qtde);
        $this->parcela->setValorPendencia($valorDasParcelas);
        
        return $this->parcela->salvar();
    }
    
    /**
     * Deleta do Banco de Dados as informações do pagamento parcelado.
     * 
     * @access public
     * @param int $pagamento Código do pagamento desejado.
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function remover($pagamento){
        $this->parcela->setPagamento($pagamento);
        
        return $this->parcela->salvar();
    }
    
    /**
     * Pesquisar os dados dos pagamentos parcelados no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos e suas informações.
     */
    public function obterTodos(){
        return $this->parcela->obter();
    }
    
    /**
     * Pesquisar os dados do pagamento parcelado no Banco de Dados.
     * 
     * @access public
     * @param int $pagamento Código do pagamento no Banco de Dados.
     * @return array[] Retorna lista de informações do pagamento parcelado desejado.
     */
    public function obterPorPagamento($pagamento){
        $this->parcela->setPagamento($pagamento);
        
        return $this->parcela->obter();
    }
    
    /**
     * Confere se o pagamento foi parcelado ou não.
     * 
     * @access public
     * @param int $pagamento Código do pagamento no Banco de Dados
     * @return boolean Retorna TRUE se existe pagamento parcelado e FALSE se não.
     */
    public function conferePagamentoParcelado($pagamento){
        $this->parcela->setPagamento($pagamento);
        
        return $this->parcela->confereParcelaPorPagamento();
    }
}