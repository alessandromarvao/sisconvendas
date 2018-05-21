<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada a autentica��o do usu�rio no Sistema. A senha � 
 * codificada pelo algor�tmo MD5.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Autenticacao {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
     /**
      * Vari�vel que recebe o login do usu�rio
      * 
      * @var String
      * @access private
      */
    private $login;
    
     /**
      * Vari�vel que recebe a senha do usu�rio
      * 
      * @var String
      * @access private
      */
    private $pwd;
    
    /**
     * Vari�vel que armazena a situa��o do usu�rio 
     * (bloquear: TRUE ou FALSE) no sistema
     *
     * @var int
     * @access private 
     */
    private $bloquear;
    
    /**
     * Inicia as opera��es de autentica��o do Usu�rio do Sistema no BD.
     * Retorna o login do usu�rio e a senha codificada.
     * 
     * @return void
     */
    function __construct() {
        //Inicia a conex�o com o Banco de Dados.
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com par�metros, encaminha ao construtor desejado
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a);
        }
    }
    
    /**
     * Vari�vel m�gica, pode retornar a vari�vel citada no par�metro.
     * 
     * @access public
     * @param String $name Nome da vari�vel que voc� deseja obter informa��o.
     * @return String
     */
    public function __get($name) {
        return $this->$name;
    }
    
    /**
     * Armazena o login citado no par�metro na vari�vel.
     * 
     * @access public
     * @param string $usuario Login do usu�rio.
     */
    public function setLogin($usuario){
        $this->login = strtolower($usuario);
    }
    
    /**
     * Armazena a senha na vari�vel.
     * 
     * @access public
     * @param string $senha Senha do usu�rio.
     */
    public function setPwd($senha){
        $this->pwd = md5($senha);
    }
    
    /**
     * Armazena a situa��o do usu�rio no Sistema.
     * 
     * @access public
     * @param int $bloquear
     */
    public function setBloquear($bloquear){
        $this->bloquear = $bloquear;
    }
    
    /**
     * Armazena as informa��es de autentica��o do usu�rio citadas nos par�metros para o BD. A ordem dos par�metros deve ser obedecida. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param String $login Login do usu�rio a ser cadastrado no Sistema.
     * @param String $pwd Senha do usu�rio a ser cadastrado no Sistema.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($login, $pwd){
        $this->login = strtolower($login);
        $this->pwd = md5($pwd);
        $this->bloquear = 0;
        
        $stmt = $this->conexao->prepare('INSERT INTO autenticacao VALUES (?, ?, ?)');
        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, $this->pwd);
        $stmt->bindParam(3, $this->bloquear);

        return $stmt->execute();
    }
    
    /**
     * Altera os dados de autentica��o do usu�rio no Sistema.
     * 
     * @access public
     * @param string $login Login do usu�rio.
     * @param string $pwd Senha do usu�rio.
     * @param int $bloquear 0 para usu�rio desbloqueado e 1 para bloquear acesso.
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * False se ocorrer algum erro.
     */
    public function alterar($login, $pwd, $bloquear){
        $this->login = strtolower($login);
        $this->pwd = md5($pwd);
        $this->bloquear = (int) $bloquear;
        
        $query = "UPDATE autenticacao SET pwd=?, bloquear=? WHERE login=?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(1, $this->pwd);
        $stmt->bindParam(2, $this->bloquear);
        $stmt->bindParam(3, $this->login);

        return $stmt->execute();
    }
    
    /**
     * Deleta do BD as informa��es do usu�rio selecionado.
     * N�o poder� ser deletado do Banco de Dados o usu�rio que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @param string $usuario Login do usu�rio existente no Sistema
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($usuario){
        if(!empty($usuario)){
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados de autentica��o de todos os usu�rios ou apenas um
     * (se selecionado) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informa��es de autentica��o do(s) usu�rio(s)
     */
    public function obter(){
        $query = "SELECT login, pwd, bloquear FROM autenticacao";
        if(isset($this->login)){
            $query .= " WHERE login=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->login);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}