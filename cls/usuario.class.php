<?php
include_once 'conexao.class.php';

/**
 * Classe relacionada ao usu�rio do Sistema e suas informa��es pessoais,
 * tais como nome, cpf, fun��o, telefone, celular, e situa��o.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Usuario {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object Retorna a conex�o PDO
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
      * Vari�vel que recebe o nome do usu�rio
      * 
      * @var String
      * @access private
      */
    private $nome;
    
    /**
      * Vari�vel que recebe o cpf do usu�rio
      * 
      * @var String
      * @access private
      */
    private $cpf;
    
    /**
      * Vari�vel que recebe a fun��o do usu�rio (vendedor ou administrador)
      * 
      * @var String
      * @access private
      */
    private $funcao;
    
    /**
      * Vari�vel que recebe o email do usu�rio
      * 
      * @var String
      * @access private
      */
    private $email;
    
    /**
      * Vari�vel que recebe o n�mero do telefone fixo do usu�rio
      * 
      * @var String
      * @access private
      */
    private $telefone;
    
    /**
      * Vari�vel que recebe n�mero do telefone celular do usu�rio
      * 
      * @var String
      * @access private
      */
    private $celular;
    
    /**
      * Vari�vel que recebe n�mero do telefone celular do usu�rio
      * 
      * @var String
      * @access private
      */
    private $celular2;
    
    /**
      * Vari�vel que recebe a situa��o do usu�rio no Sistema (ativo ou desativado)
      * 
      * @var String
      * @access private
      */
    private $situacao;
    
    /**
      * Vari�vel que recebe a data de nascimento do usu�rio no Sistema (ativo ou desativado)
      * 
      * @var String
      * @access private
      */
    private $dataNascimento;
    
    /**
     * Inicia as opera��es do Usu�rio do Sistema no BD.
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
     * Inicia as opera��es do Usu�rio do Sistema no BD.
     * 
     * @param string $login Login do usu�rio no Sistema.
     * @return void
     */
    function __construct1($login){
        $this->login = $login;
    }
    
    /**
     * Vari�vel m�gica, pode retornar a vari�vel citada no par�metro.
     * 
     * @access public
     * @param String $nome
     * @return String
     */
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena na vari�vel login o valor citado no par�metro.
     * 
     * @access public
     * @param String $valor Login do usu�rio
     */
    public function setLogin($valor){
        $this->login = strtolower($valor);
    }
    
    /**
     * Armazena na vari�vel nome o valor citado no par�metro.
     * 
     * @access public
     * @param String $valor Nome do usu�rio
     */
    public function setNome($valor){
        $this->nome = strtoupper($valor);
    }
    
    /**
     * Armazena na vari�vel cpf o valor citado no par�metro.
     * 
     * @access public
     * @param String $valor Nome do usu�rio
     */
    public function setCPF($valor){
        $this->cpf = $valor;
    }
    
    /**
     * Armazena na vari�vel situacao o valor citado no par�metro.
     * 
     * @access public
     * @param String $valor Situa��o atual do funcion�rio do Sistema
     */
    public function setSituacao($valor){
        $this->situacao = $valor;
    }
    
    /**
     * Confere se o usu�rio desejado j� est� cadastrado no Sistema.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    private function existeUsuario(){
        $stmt = $this->conexao->prepare("SELECT count(login_FK) FROM usuario WHERE login_FK=?");
        $stmt->bindParam(1, $this->login);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC)['count(login_FK)'];
    }
    
    /**
     * Armazena as informa��es pessoais do usu�rio citadas nos 
     * par�metros para o BD. A ordem dos par�metros deve ser obedecida.
     * Retorna TRUE ou FALSE.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($login, $nome, $funcao, $cpf, $email, $telefone, $celular1, $celular2, $data_nascimento){
        $this->login = strtolower($login);
        $this->nome = strtoupper($nome);
        $this->funcao= $funcao;
        $this->cpf = $cpf;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->celular = $celular1;
        $this->celular2 = $celular2;
        $this->dataNascimento = $data_nascimento;
        $this->situacao = "ativo";
        
        if($this->existeUsuario()){ //Atualiza
            return $this->update();
        } else { //Salva novo
            return $this->insert();
        }
    }
    
    /**
     * Armazena um novo usu�rio no Sistema.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    private function insert(){
        $stmt = $this->conexao->prepare("INSERT INTO usuario VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bindParam(1, $this->login);
        $stmt->bindParam(2, $this->nome);
        $stmt->bindParam(3, $this->funcao);
        $stmt->bindParam(4, $this->cpf);
        $stmt->bindParam(5, $this->email);
        $stmt->bindParam(6, $this->telefone);
        $stmt->bindParam(7, $this->celular);
        $stmt->bindParam(8, $this->celular2);
        $stmt->bindParam(9, $this->situacao);
        $stmt->bindParam(10, $this->dataNascimento);
        
        return $stmt->execute();
    }
    
    /**
     * Altera as informa��es do usu�rio desejado.
     * 
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    public function update(){
        $query = "UPDATE usuario SET nome=?, funcao=?, cpf=?, email=?, telefone=?, cel1=?, cel2=?, situacao=?, data_nasc_usr=? WHERE login_FK=?";
        
        $stmt = $this->conexao->prepare($query);
        
        $stmt->bindParam(1, $this->nome);
        $stmt->bindParam(2, $this->funcao);
        $stmt->bindParam(3, $this->cpf);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->telefone);
        $stmt->bindParam(6, $this->celular);
        $stmt->bindParam(7, $this->celular2);
        $stmt->bindParam(8, $this->situacao);
        $stmt->bindParam(9, $this->dataNascimento);
        $stmt->bindParam(10, $this->login);
        
        return $stmt->execute();
    }
    
    /**
     * Bloqueia ou libera acesso do usu�rio desejado.
     * 
     * @param string $login Login do usu�rio.
     * @param boolean $bool TRUE para bloquear acesso e FALSE para liberar.
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    public function bloquearAcesso($login, $bool){
        $this->login = $login;
        $stmt = $this->conexao->prepare("UPDATE usuario SET situacao=? WHERE login_FK=?");
        if($bool){
            $situacao="bloqueado";
        } else {
            $situacao="ativo";
        }
        $stmt->bindParam(1, $situacao);
        $stmt->bindParam(2, $this->login);
        
        return $stmt->execute();
    }
    
    /**
     * Altera a fun��o do usu�rio desejado.
     * 
     * @param string $login Login do usu�rio.
     * @param string $funcao Fun��o desejada.
     * @return boolean Retorna TRUE se a condi��o for v�lida e FALSE caso negativo.
     */
    public function alterarFuncao($login, $funcao){
        $this->login = $login;
        $this->funcao = $funcao;
        
        $stmt = $this->conexao->prepare("UPDATE usuario SET funcao=? WHERE login_FK=?");
        $stmt->bindParam(1, $this->funcao);
        $stmt->bindParam(2, $this->login);
        
        return $stmt->execute();
    }
    
    /**
     * Deleta do BD as informa��es do usu�rio selecionado.
     * N�o poder� ser deletado do Banco de Dados o usu�rio que j� realizou algum
     * cadastro no Sistema.
     * 
     * @param string $login Login do usu�rio existente no Sistema
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($login){
        if(!empty($login)){
            $stmt = $this->conexao->prepare("DELETE FROM usuario WHERE login_FK=?");
            $stmt->bindParam(1, $login);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar todos os dados dos funcion�rios do Sistema ou de apenas 
     * um (se for selecionado no Sistema). 
     * 
     * @access public
     * @return array Retorna lista de informa��es do(s) usu�rio(s)
     */
    public function obter(){
        $query = "SELECT login_FK, nome, cpf, funcao, email, telefone, cel1, cel2, situacao, data_nasc_usr FROM usuario";
        if(!empty($this->login)){
            $query .= " WHERE login_FK=?";
            $login = $this->login;
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $login);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->nome)){
            $query .= " WHERE nome like ?";
            $nome = "%" . $this->nome . "%";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $nome);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->cpf)){
            $query .= " WHERE cpf like ?";
            $stmt = $this->conexao->prepare($query);
            $cpf = $this->cpf . "%";
            $stmt->bindParam(1, $cpf);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->funcao)){
            $query .= " WHERE funcao like ?";
            $stmt = $this->conexao->prepare($query);
            $funcao = $this->funcao . "%";
            $stmt->bindParam(1, $funcao);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->situacao)){
            $query .= " WHERE situacao like ?";
            $stmt = $this->conexao->prepare($query);
            $situacao = $this->situacao . "%";
            $stmt->bindParam(1, $situacao);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}