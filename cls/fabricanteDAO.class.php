<?php
include_once 'fabricante.class.php';

/**
 * Classe relacionada �s opera��es das empresas fabricantes de m�veis no Banco de Dados.
 * Armazena as informa��es dos fabricantes (c�digo, nome da empresa e telefone) para
 * facilitar o contato com os mesmos.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class FabricanteDAO {
    /**
     * Vari�vel que recebe o objeto da classe Fabricante.
     *
     * @access private
     * @var Object 
     */
    private $fabricante;
    
    /**
     * Inicia as opera��es relacionadas � empresa fornecedora no BD.
     * 
     * @return void
     */
    function __construct() {
        $this->fabricante = new Fabricante();
    }
    
    /**
     * Armazena as informa��es do fabricante de m�veis no Banco de Dados.
     * 
     * @access public
     * @param string $nome Raz�o social da empresa fornecedora.
     * @param string $telefone Telefone da empresa fornecedora.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($nome, $contato, $telefone, $celular, $representante, $cel1_representante, $cel2_representante){
        $this->fabricante->setEmpresa($nome);
        $this->fabricante->setContato($contato);
        $this->fabricante->setTelefone($telefone);
        $this->fabricante->setCelular($celular);
        $this->fabricante->setRepresentante($representante);
        $this->fabricante->setCel1Representante($cel1_representante);
        $this->fabricante->setCel2Representante($cel2_representante);
        
        return $this->fabricante->salvar();
    }
    
    /**
     * Modifica as informa��es da empresa fabricate de m�veis no Banco de Dados.
     * 
     * @access public
     * @param int $id C�digo da empresa fornecedora.
     * @param string $nome Raz�o social da empresa fornecedora.
     * @param string $telefone Telefone da empresa fornecedora.
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar($id, $nome, $contato, $telefone, $celular, $representante, $cel1_representante, $cel2_representante){
        $this->fabricante->setId($id);
        $this->fabricante->setEmpresa($nome);
        $this->fabricante->setContato($contato);
        $this->fabricante->setTelefone($telefone);
        $this->fabricante->setCelular($celular);
        $this->fabricante->setRepresentante($representante);
        $this->fabricante->setCel1Representante($cel1_representante);
        $this->fabricante->setCel2Representante($cel2_representante);
        
        return $this->fabricante->alterar();
    }
    
    /**
     * Deleta do Banco de Dados as informa��es da empresa fabricante de m�veis selecionada.
     * N�o poder� ser deletado do Banco de Dados a empresa que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @param int $id C�digo da empresa fornecedora.
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($id){
        $this->fabricante->setId($id);
        
        return $this->fabricante->remover();
    }
    
    /**
     * Pesquisar os dados de todas as empresas fabricantes de m�veis no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informa��es das empresas.
     */
    public function obter(){
        return $this->fabricante->obter();
    }
    
    /**
     * Pesquisar os dados da empresa fabricante de m�veis desejada no Sistema.
     * 
     * @access public
     * @param int $id C�digo da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informa��es da empresa.
     */
    public function obterPorId($id){
        $this->fabricante->setId($id);
        
        return $this->fabricante->obter();
    }
    
     /**
     * Pesquisar os dados da empresa fabricante de m�veis desejada no Sistema.
     * 
     * @access public
     * @param string $nome Raz�o social da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informa��es da empresa.
     */
    public function obterPorNome($nome){
        $this->fabricante->setEmpresa($nome);
        
        return $this->fabricante->obter();
    }
    
    /**
     * Pesquisar os dados das empresas fabricante de m�veis desejada no Sistema de acordo com o nome.
     * 
     * @access public
     * @param string $nome Raz�o social da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informa��es da empresa.
     */
    public function pesquisar($nome){
        $this->fabricante->setEmpresa($nome);
        
        return $this->fabricante->pesquisar();
    }
    
    /**
     * Pesquisar os dados das empresas fabricante de m�veis desejada no Sistema de acordo com o nome do representante comercial.
     * 
     * @access public
     * @param string $nome Nome do representante comercial da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informa��es da empresa.
     */
    public function pesquisarRepresentante($nome){
        $this->fabricante->setRepresentante($nome);
        
        return $this->fabricante->pesquisar();
    }
}
