<?php
include_once 'conexao.class.php';

/**
 * Classe relacionada ao usuário do Sistema e suas informações pessoais,
 * tais como nome, cpf, função, telefone, celular, e situação.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class Usuario {
    /**
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object Retorna a conexão PDO
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
      * Variável que recebe o nome do usuário
      * 
      * @var String
      * @access private
      */
    private $nome;
    
    /**
      * Variável que recebe o cpf do usuário
      * 
      * @var String
      * @access private
      */
    private $cpf;
    
    /**
      * Variável que recebe a função do usuário (vendedor ou administrador)
      * 
      * @var String
      * @access private
      */
    private $funcao;
    
    /**
      * Variável que recebe o email do usuário
      * 
      * @var String
      * @access private
      */
    private $email;
    
    /**
      * Variável que recebe o número do telefone fixo do usuário
      * 
      * @var String
      * @access private
      */
    private $telefone;
    
    /**
      * Variável que recebe número do telefone celular do usuário
      * 
      * @var String
      * @access private
      */
    private $celular;
    
    /**
      * Variável que recebe número do telefone celular do usuário
      * 
      * @var String
      * @access private
      */
    private $celular2;
    
    /**
      * Variável que recebe a situação do usuário no Sistema (ativo ou desativado)
      * 
      * @var String
      * @access private
      */
    private $situacao;
    
    /**
      * Variável que recebe a data de nascimento do usuário no Sistema (ativo ou desativado)
      * 
      * @var String
      * @access private
      */
    private $dataNascimento;
    
    /**
     * Inicia as operações do Usuário do Sistema no BD.
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
     * Inicia as operações do Usuário do Sistema no BD.
     * 
     * @param string $login Login do usuário no Sistema.
     * @return void
     */
    function __construct1($login){
        $this->login = $login;
    }
    
    /**
     * Variável mágica, pode retornar a variável citada no parâmetro.
     * 
     * @access public
     * @param String $nome
     * @return String
     */
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena na variável login o valor citado no parâmetro.
     * 
     * @access public
     * @param String $valor Login do usuário
     */
    public function setLogin($valor){
        $this->login = strtolower($valor);
    }
    
    /**
     * Armazena na variável nome o valor citado no parâmetro.
     * 
     * @access public
     * @param String $valor Nome do usuário
     */
    public function setNome($valor){
        $this->nome = strtoupper($valor);
    }
    
    /**
     * Armazena na variável cpf o valor citado no parâmetro.
     * 
     * @access public
     * @param String $valor Nome do usuário
     */
    public function setCPF($valor){
        $this->cpf = $valor;
    }
    
    /**
     * Armazena na variável situacao o valor citado no parâmetro.
     * 
     * @access public
     * @param String $valor Situação atual do funcionário do Sistema
     */
    public function setSituacao($valor){
        $this->situacao = $valor;
    }
    
    /**
     * Confere se o usuário desejado já está cadastrado no Sistema.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condição for válida e FALSE caso negativo.
     */
    private function existeUsuario(){
        $stmt = $this->conexao->prepare("SELECT count(login_FK) FROM usuario WHERE login_FK=?");
        $stmt->bindParam(1, $this->login);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC)['count(login_FK)'];
    }
    
    /**
     * Armazena as informações pessoais do usuário citadas nos 
     * parâmetros para o BD. A ordem dos parâmetros deve ser obedecida.
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
     * Armazena um novo usuário no Sistema.
     * 
     * @access private
     * @return boolean Retorna TRUE se a condição for válida e FALSE caso negativo.
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
     * Altera as informações do usuário desejado.
     * 
     * @return boolean Retorna TRUE se a condição for válida e FALSE caso negativo.
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
     * Bloqueia ou libera acesso do usuário desejado.
     * 
     * @param string $login Login do usuário.
     * @param boolean $bool TRUE para bloquear acesso e FALSE para liberar.
     * @return boolean Retorna TRUE se a condição for válida e FALSE caso negativo.
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
     * Altera a função do usuário desejado.
     * 
     * @param string $login Login do usuário.
     * @param string $funcao Função desejada.
     * @return boolean Retorna TRUE se a condição for válida e FALSE caso negativo.
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
     * Deleta do BD as informações do usuário selecionado.
     * Não poderá ser deletado do Banco de Dados o usuário que já realizou algum
     * cadastro no Sistema.
     * 
     * @param string $login Login do usuário existente no Sistema
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
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
     * Pesquisar todos os dados dos funcionários do Sistema ou de apenas 
     * um (se for selecionado no Sistema). 
     * 
     * @access public
     * @return array Retorna lista de informações do(s) usuário(s)
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