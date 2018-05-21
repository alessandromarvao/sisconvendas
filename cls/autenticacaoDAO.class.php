<?php
include_once 'autenticacao.class.php';
include_once 'senha_padrao.class.php';
include_once 'tentativasDAO.class.php';

/**
 * Classe relacionada a autenticação do usuário no Sistema. A senha é 
 * codificada pelo algorítmo MD5.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class AutenticacaoDAO {
    /**
     * Variável que recebe o objeto da classe Autenticacao.
     *
     * @access private
     * @var Object 
     */
    private $aut;
    
    /**
     * Variável que recebe o objeto da classe Senha_padraoDAO.
     *
     * @access private
     * @var Object 
     */
    private $padrao;
    
    /**
     * Inicia as operações de autenticação do Usuário do Sistema no BD.
     * 
     * @return void 
     */
    function __construct() {
        $this->aut = new Autenticacao();
        $this->padrao = new Senha_padrao();
    }
    
    /**
     * Armazena as informações de autenticação do usuário no Banco de Dados.
     * 
     * @param string $usuario Login do usuário.
     * @param string $senha Senha do usuário.
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
     * Retorna lista de informações do usuário desejado, caso o mesmo exista.
     * 
     * @access private
     * @param string $usuario Login do usuário.
     * @return array Lista de informações do usuário desejado.
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
     * Confere se a autenticação do usuário desejado.
     * 
     * @param string $usuario Login do Usuário.
     * @param string $senha Senha do usuário.
     * @return string Retorna OK se houver a autenticidade dos dados, PWD_FAIL se a senha estiver incorreta e FALSE se houver falha na autenticação.
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
     * Altera a senha do usuário citado.
     * 
     * @access public
     * @param string $usuario Login do usuário.
     * @param string $senha Nova senha do usuário.
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso
     */
    public function alterarSenha($usuario, $senha){        
        return $this->aut->alterar($usuario, $senha, 0);
    }
    
    /**
     * Confere se o usuário bloqueou ou não o seu acesso por errar a senha por várias vezes.
     * 
     * @param string $usuario Login do usuário desejado.
     * @return boolean Retorna TRUE se o usuário bloqueou seu acesso por errar a senha e FALSE se está tudo certo.
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
     * Desbloqueia o acesso do usuário e restaura a senha padrão.
     * 
     * @param string $usuario
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se houver alguma falha.
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
     * Bloqueia o acesso do usuário e restaura a senha padrão.
     * 
     * @param string $usuario
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se houver alguma falha.
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