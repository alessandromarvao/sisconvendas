<?php
include_once 'autenticacao.class.php';
include_once 'senha_padrao.class.php';
include_once 'tentativasDAO.class.php';

/**
 * Classe relacionada a autentica��o do usu�rio no Sistema. A senha � 
 * codificada pelo algor�tmo MD5.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class AutenticacaoDAO {
    /**
     * Vari�vel que recebe o objeto da classe Autenticacao.
     *
     * @access private
     * @var Object 
     */
    private $aut;
    
    /**
     * Vari�vel que recebe o objeto da classe Senha_padraoDAO.
     *
     * @access private
     * @var Object 
     */
    private $padrao;
    
    /**
     * Inicia as opera��es de autentica��o do Usu�rio do Sistema no BD.
     * 
     * @return void 
     */
    function __construct() {
        $this->aut = new Autenticacao();
        $this->padrao = new Senha_padrao();
    }
    
    /**
     * Armazena as informa��es de autentica��o do usu�rio no Banco de Dados.
     * 
     * @param string $usuario Login do usu�rio.
     * @param string $senha Senha do usu�rio.
     * @return boolean
     */
    public function salvar($usuario){
        $padrao = $this->padrao->obter();
        $tamanho = sizeof($padrao);
        if($tamanho==4) {
            
            return $this->aut->salvar($usuario, $padrao['padrao_decod']);
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna lista de informa��es do usu�rio desejado, caso o mesmo exista.
     * 
     * @access private
     * @param string $usuario Login do usu�rio.
     * @return array Lista de informa��es do usu�rio desejado.
     */
    private function confereBloquear($usuario){
        $this->aut->setLogin($usuario);
        $resultado = $this->aut->obter();
        if(sizeof($resultado)==3 && $resultado['bloquear']==0){
            return $resultado;
        } else {
            return NULL;
        }
    }
    
    /**
     * Confere se a autentica��o do usu�rio desejado.
     * 
     * @param string $usuario Login do Usu�rio.
     * @param string $senha Senha do usu�rio.
     * @return string Retorna OK se houver a autenticidade dos dados, PWD_FAIL se a senha estiver incorreta e FALSE se houver falha na autentica��o.
     */
    public function confereAutenticacao($usuario, $senha){
        $this->aut->setLogin($usuario);
        $senhaCodificada = md5($senha);
        
        $resultado = $this->confereBloquear($usuario);
        if(!empty($resultado)){
            if(strcmp($resultado['pwd'], $senhaCodificada)==0){
                return "OK";
            } else {
                return "PWD_FAIL";
            }
        } else {
            return "FALSE";
        }
    }
    
    /**
     * Altera a senha do usu�rio citado.
     * 
     * @access public
     * @param string $usuario Login do usu�rio.
     * @param string $senha Nova senha do usu�rio.
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso
     */
    public function alterarSenha($usuario, $senha){        
        return $this->aut->alterar($usuario, $senha, 0);
    }
    
    /**
     * Confere se o usu�rio bloqueou ou n�o o seu acesso por errar a senha por v�rias vezes.
     * 
     * @param string $usuario Login do usu�rio desejado.
     * @return boolean Retorna TRUE se o usu�rio bloqueou seu acesso por errar a senha e FALSE se est� tudo certo.
     */
    public function isSenhaExpirada($usuario){
        $this->aut->setLogin($usuario);
        
        $resultado = $this->aut->obter();
        if($resultado['bloquear']==0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * Desbloqueia o acesso do usu�rio e restaura a senha padr�o.
     * 
     * @param string $usuario
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e FALSE se houver alguma falha.
     */
    public function desbloquear($usuario){
        $senha = $this->padrao->obter()['padrao_decod'];
        if(!empty($this->aut->obter())){
            $tentativas = new TentativasDAO();
            $tentativas->removerTentativasDoDia($usuario);
            return $this->aut->alterar($usuario, $senha, 0);
        } else {
            return FALSE;
        }
    }
    
    /**
     * Bloqueia o acesso do usu�rio e restaura a senha padr�o.
     * 
     * @param string $usuario
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e FALSE se houver alguma falha.
     */
    public function bloquear($usuario){
        $this->aut->setLogin($usuario);
        $resultado = $this->aut->obter();
        if(!empty($resultado)){            
            return $this->aut->alterar($usuario, $resultado['pwd'], 1);
        } else {
            return FALSE;
        }
    }
    
    public function obterAutenticacao($usuario){
        $this->aut->setLogin($usuario);
        
        return $resultado = $this->aut->obter();
    }
}