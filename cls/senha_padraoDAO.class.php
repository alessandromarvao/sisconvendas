<?php
include_once 'senha_padrao.class.php';

/**
 * Classe que designa uma senha padr�o a ser utilizada na
 * autentica��o do usu�rio no Sistema de Controle de Estoque e Vendas.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Senha_padraoDAO {
    /**
     * Vari�vel que recebe o objeto da classe Senha_padrao.
     * 
     * @access private
     * @var Object
     */
    private $padrao;
    
    /**
     * Vari�vel que recebe todas as informa��es da senha padr�o.
     * 
     * @access private
     * @var Object
     */
    private $resultado;
    
    /**
     * Inicia as opera��es da senha padr�o no BD.
     * 
     * @return void 
     */
    function __construct() {
        $this->padrao = new Senha_padrao();
        $this->resultado = $this->padrao->obter();
    }
    
    /**
     * Armazena a senha padr�o para o BD. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param String $senha
     * @return bool Retorna TRUE se a opera��o ocorreu com sucesso e 
     * FALSE se houve alguma falha na opera��o com o BD.
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