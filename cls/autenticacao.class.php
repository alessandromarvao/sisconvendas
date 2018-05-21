<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada a autenticação do usuário no Sistema. A senha é 
 * codificada pelo algorítmo MD5.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class Autenticacao {
    /**
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
     /**
      * Variável que recebe o login do usuário
      * 
      * @var String
      * @access private
      */
    private $login;
    
     /**
      * Variável que recebe a senha do usuário
      * 
      * @var String
      * @access private
      */
    private $pwd;
    
    /**
     * Variável que armazena a situação do usuário 
     * (bloquear: TRUE ou FALSE) no sistema
     *
     * @var int
     * @access private 
     */
    private $bloquear;
    
    /**
     * Inicia as operações de autenticação do Usuário do Sistema no BD.
     * Retorna o login do usuário e a senha codificada.
     * 
     * @return void
     */
    function __construct() {
        //Inicia a conexão com o Banco de Dados.
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com parâmetros, encaminha ao construtor desejado
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a);
        }
    }
    
    /**
     * Variável mágica, pode retornar a variável citada no parâmetro.
     * 
     * @access public
     * @param String $name Nome da variável que você deseja obter informação.
     * @return String
     */
    public function __get($name) {
        return $this->$name;
    }
    
    /**
     * Armazena o login citado no parâmetro na variável.
     * 
     * @access public
     * @param string $usuario Login do usuário.
     */
    public function setLogin($usuario){
        $this->login = strtolower($usuario);
    }
    
    /**
     * Armazena a senha na variável.
     * 
     * @access public
     * @param string $senha Senha do usuário.
     */
    public function setPwd($senha){
        $this->pwd = md5($senha);
    }
    
    /**
     * Armazena a situação do usuário no Sistema.
     * 
     * @access public
     * @param int $bloquear
     */
    public function setBloquear($bloquear){
        $this->bloquear = $bloquear;
    }
    
    /**
     * Armazena as informações de autenticação do usuário citadas nos parâmetros para o BD. A ordem dos parâmetros deve ser obedecida. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param String $login Login do usuário a ser cadastrado no Sistema.
     * @param String $pwd Senha do usuário a ser cadastrado no Sistema.
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
     * Altera os dados de autenticação do usuário no Sistema.
     * 
     * @access public
     * @param string $login Login do usuário.
     * @param string $pwd Senha do usuário.
     * @param int $bloquear 0 para usuário desbloqueado e 1 para bloquear acesso.
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
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
     * Deleta do BD as informações do usuário selecionado.
     * Não poderá ser deletado do Banco de Dados o usuário que já realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @param string $usuario Login do usuário existente no Sistema
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
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
     * Pesquisar os dados de autenticação de todos os usuários ou apenas um
     * (se selecionado) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informações de autenticação do(s) usuário(s)
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