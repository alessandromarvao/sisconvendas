<?php
include_once 'movel_possui_venda.class.php';

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
class MovelPossuiVendaDAO {
    /**
     * Vari�vel que recebe o objeto da classe movel_possui_venda.
     * 
     * @access private
     * @var Object
     */
    private $vendaDeMovel;
    
    function __construct() {
        $this->vendaDeMovel = new Movel_possui_venda();
    }
    
    /**
     * Armazena as informa��es relacionadas � venda do 
     * m�vel espec�fico no Banco de Dados.
     * 
     * @access public
     * @param int $movel C�digo do m�vel vendido.
     * @param int $venda C�digo da venda.
     * @param double $valor Valor do m�vel.
     * @param int $qtde Quantidade vendida do m�vel.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($movel, $venda, $valor, $qtde, $entrega, $montagem){
        $this->vendaDeMovel->setMovel($movel);
        $this->vendaDeMovel->setVenda($venda);
        $this->vendaDeMovel->setValor($valor);
        $this->vendaDeMovel->setQtde($qtde);
        $this->vendaDeMovel->setEntrega($entrega);
        $this->vendaDeMovel->setMontagem($montagem);
        
        return $this->vendaDeMovel->salvar();
    }
    
    public function obterUltimoRegistro(){
        return $this->vendaDeMovel->obterUltimoRegistro();
    }
    
    /**
     * Pesquisa os m�veis vendidos de acordo com a nota de venda.
     * 
     * @param int $nota C�digo da nota de venda
     * @return array[] Retorna uma lista de vendas e suas informa��es
     */
    public function obterPorVenda($nota){
        $this->vendaDeMovel->setVenda($nota);
        
        return $this->vendaDeMovel->obter();
    }
    
    /**
     * Pesquisa os m�veis vendidos de acordo com o seu c�digo.
     * 
     * @param int $id C�digo da compra do m�vel
     * @return array[] Retorna uma lista de vendas e suas informa��es
     */
    public function obterPorID($id){
        $this->vendaDeMovel->setId($id);
        
        return $this->vendaDeMovel->obter();
    }
}