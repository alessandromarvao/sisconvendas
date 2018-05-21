<?php
include_once 'usuario.class.php';

/**
 * Classe relacionada ao usu�rio do Sistema e suas informa��es pessoais,
 * tais como nome, cpf, fun��o, telefone, celular, e situa��o.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class UsuarioDAO {
    /**
     * Vari�vel que recebe o objeto da classe Usuario.
     *
     * @access private
     * @var Object 
     */
    private $usuario;
    
    /**
     * Inicia as opera��es do Usu�rio do Sistema no BD.
     * Retorna o login do usu�rio e a senha codificada.
     * 
     * @return void
     */
    function __construct() {
        $this->usuario = new Usuario();
    }
    
    /**
     * Armazena as informa��es pessoais do usu�rio citadas nos 
     * par�metros para o BD.
     * 
     * @access public
     * @param string $login Login do usu�rio no Sistema.
     * @param string $nome Nome completo do usu�rio.
     * @param string $funcao Fun��o que o usu�rio exerce na empresa.
     * @param string $cpf CPF do usu�rio especificado.
     * @param string $email E-mail do usu�rio especificado.
     * @param string $telefone N�mero do telefone fixo do usu�rio (opcional).
     * @param string $celular1 N�mero do telefone celular do usu�rio(opcional).
     * @param string $celular2 N�mero do telefone celular do usu�rio(opcional).
     * @param string $dataNascimento Data de anivers�rio do usu�rio(opcional).
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($login, $nome, $funcao, $cpf, $email, $telefone, $celular1, $celular2, $dataNascimento){
        $this->usuario->setLogin($login);
        
        $resultado = $this->usuario->obter();
        
        $this->usuario->setNome($nome);
        $this->usuario->setFuncao($funcao);
        $this->usuario->setCPF($cpf);
        $this->usuario->setEmail($email);
        $this->usuario->setTelefone($telefone);
        $this->usuario->setCelular($celular1);
        $this->usuario->setCelular2($celular2);
        $this->usuario->setDataNascimento($dataNascimento);
        
        if(count($resultado)==10){
            $this->usuario->setSituacao($resultado['situacao']);
            
            return $this->usuario->alterar();        
        } else {
            return $this->usuario->salvar();        
        }
        
    }
    
    /**
     * Altera a situa��o do usu�rio citado, mantendo as outras informa��es intactas.
     * 
     * @param string $login Login do usu�rio desejado.
     * @param string $situacao Situa��o do usu�rio no Sistema (ativo ou bloqueado).
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterarFuncao($login, $situacao){
        $this->usuario->setLogin($login);
        $resultado = $this->usuario->obter();
        
        if(!empty($resultado) && !empty($situacao)){
            $this->usuario->setNome($resultado['nome']);
            $this->usuario->setSituacao($resultado['funcao']);
            $this->usuario->setCPF($resultado['cpf']);
            $this->usuario->setTelefone($resultado['telefone']);
            $this->usuario->setCelular($resultado['celular']);
            $this->usuario->setFuncao($situacao);
            
            return $this->usuario->alterar();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna as informa��es de todos os usu�rios do Sistema.
     * 
     * @return array Retorna lista contendo todas as informa��es de todos os usu�rios do Sistema.
     */
    public function obterTodos(){
        return $this->usuario->obter();
    }
    
    /**
     * Retorna as informa��es do usu�rio definido pelo login.
     * 
     * @param string $login Login do usu�rio desejado.
     * @return array Retorna lista de informa��es do usu�rio definido pelo login.
     */
    public function obterPorLogin($login){
        $this->usuario->setLogin($login);
        
        return $this->usuario->obter();
    }
    
    public function obterPorNome($nome){
        $this->usuario->setNome($nome);
        
        return $this->usuario->obter();
    }
    
    /**
     * Retorna as informa��es dos usu�rios com o nome igual ao passado no par�metro.
     * 
     * @param string $nome Nome a ser pesquisado. Quanto mais detalhes tiver no nome, melhor ser� a busca.
     * @return array Retorna lista de informa��es dos usu�rios.
     */
    public function pesquisarPorNome($nome){
        $this->usuario->setNome($nome);
        
        return $this->usuario->obter();
    }
    
    /**
     * Retorna as informa��es dos usu�rios com a situa��o citada.
     * 
     * @param string $situacao Situa��o desejada na busca.
     * @return array Retorna lista de informa��es dos usu�rios.
     */
    public function obterPorSituacao($situacao){
        $this->usuario->setSituacao($situacao);
        
        return $this->usuario->obter();
    }
}