<?php
include_once 'fabricante.class.php';

/**
 * Classe relacionada às operações das empresas fabricantes de móveis no Banco de Dados.
 * Armazena as informações dos fabricantes (código, nome da empresa e telefone) para
 * facilitar o contato com os mesmos.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class FabricanteDAO {
    /**
     * Variável que recebe o objeto da classe Fabricante.
     *
     * @access private
     * @var Object 
     */
    private $fabricante;
    
    /**
     * Inicia as operações relacionadas à empresa fornecedora no BD.
     * 
     * @return void
     */
    function __construct() {
        $this->fabricante = new Fabricante();
    }
    
    /**
     * Armazena as informações do fabricante de móveis no Banco de Dados.
     * 
     * @access public
     * @param string $nome Razão social da empresa fornecedora.
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
     * Modifica as informações da empresa fabricate de móveis no Banco de Dados.
     * 
     * @access public
     * @param int $id Código da empresa fornecedora.
     * @param string $nome Razão social da empresa fornecedora.
     * @param string $telefone Telefone da empresa fornecedora.
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
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
     * Deleta do Banco de Dados as informações da empresa fabricante de móveis selecionada.
     * Não poderá ser deletado do Banco de Dados a empresa que já realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @param int $id Código da empresa fornecedora.
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($id){
        $this->fabricante->setId($id);
        
        return $this->fabricante->remover();
    }
    
    /**
     * Pesquisar os dados de todas as empresas fabricantes de móveis no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informações das empresas.
     */
    public function obter(){
        return $this->fabricante->obter();
    }
    
    /**
     * Pesquisar os dados da empresa fabricante de móveis desejada no Sistema.
     * 
     * @access public
     * @param int $id Código da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informações da empresa.
     */
    public function obterPorId($id){
        $this->fabricante->setId($id);
        
        return $this->fabricante->obter();
    }
    
     /**
     * Pesquisar os dados da empresa fabricante de móveis desejada no Sistema.
     * 
     * @access public
     * @param string $nome Razão social da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informações da empresa.
     */
    public function obterPorNome($nome){
        $this->fabricante->setEmpresa($nome);
        
        return $this->fabricante->obter();
    }
    
    /**
     * Pesquisar os dados das empresas fabricante de móveis desejada no Sistema de acordo com o nome.
     * 
     * @access public
     * @param string $nome Razão social da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informações da empresa.
     */
    public function pesquisar($nome){
        $this->fabricante->setEmpresa($nome);
        
        return $this->fabricante->pesquisar();
    }
    
    /**
     * Pesquisar os dados das empresas fabricante de móveis desejada no Sistema de acordo com o nome do representante comercial.
     * 
     * @access public
     * @param string $nome Nome do representante comercial da empresa fornecedora.
     * @return array[] Retorna a lista contendo as informações da empresa.
     */
    public function pesquisarRepresentante($nome){
        $this->fabricante->setRepresentante($nome);
        
        return $this->fabricante->pesquisar();
    }
}
