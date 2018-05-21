<?php
include_once 'senha_padrao.class.php';

/**
 * Classe que designa uma senha padrão a ser utilizada na
 * autenticação do usuário no Sistema de Controle de Estoque e Vendas.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Senha_padraoDAO {
    /**
     * Variável que recebe o objeto da classe Senha_padrao.
     * 
     * @access private
     * @var Object
     */
    private $padrao;
    
    /**
     * Variável que recebe todas as informações da senha padrão.
     * 
     * @access private
     * @var Object
     */
    private $resultado;
    
    /**
     * Inicia as operações da senha padrão no BD.
     * 
     * @return void 
     */
    function __construct() {
        $this->padrao = new Senha_padrao();
        $this->resultado = $this->padrao->obter();
    }
    
    /**
     * Armazena a senha padrão para o BD. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param String $senha
     * @return bool Retorna TRUE se a operação ocorreu com sucesso e 
     * FALSE se houve alguma falha na operação com o BD.
     */
    public function salvar($senha){
        $this->padrao->setPadraoDecodificado($senha);
        if(empty($this->resultado)){
            return $this->padrao->salvar();
        } else {
            $this->padrao->setId($this->resultado[0]['id_padrao']);
            
            return $this->padrao->alterar();
        }
    }
    
    public function obter(){
        if(!empty($this->resultado)){
            return $this->resultado[0];
        } else {
            return NULL;
        }
    }
    
    public function retornarSenhaCodificada(){
        return $this->resultado[0]['padrao'];
    }
}