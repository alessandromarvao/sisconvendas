<?php
include_once 'usuario.class.php';

/**
 * Classe relacionada ao usuário do Sistema e suas informações pessoais,
 * tais como nome, cpf, função, telefone, celular, e situação.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class UsuarioDAO {
    /**
     * Variável que recebe o objeto da classe Usuario.
     *
     * @access private
     * @var Object 
     */
    private $usuario;
    
    /**
     * Inicia as operações do Usuário do Sistema no BD.
     * Retorna o login do usuário e a senha codificada.
     * 
     * @return void
     */
    function __construct() {
        $this->usuario = new Usuario();
    }
    
    /**
     * Armazena as informações pessoais do usuário citadas nos 
     * parâmetros para o BD.
     * 
     * @access public
     * @param string $login Login do usuário no Sistema.
     * @param string $nome Nome completo do usuário.
     * @param string $funcao Função que o usuário exerce na empresa.
     * @param string $cpf CPF do usuário especificado.
     * @param string $email E-mail do usuário especificado.
     * @param string $telefone Número do telefone fixo do usuário (opcional).
     * @param string $celular1 Número do telefone celular do usuário(opcional).
     * @param string $celular2 Número do telefone celular do usuário(opcional).
     * @param string $dataNascimento Data de aniversário do usuário(opcional).
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
     * Altera a situação do usuário citado, mantendo as outras informações intactas.
     * 
     * @param string $login Login do usuário desejado.
     * @param string $situacao Situação do usuário no Sistema (ativo ou bloqueado).
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
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
     * Retorna as informações de todos os usuários do Sistema.
     * 
     * @return array Retorna lista contendo todas as informações de todos os usuários do Sistema.
     */
    public function obterTodos(){
        return $this->usuario->obter();
    }
    
    /**
     * Retorna as informações do usuário definido pelo login.
     * 
     * @param string $login Login do usuário desejado.
     * @return array Retorna lista de informações do usuário definido pelo login.
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
     * Retorna as informações dos usuários com o nome igual ao passado no parâmetro.
     * 
     * @param string $nome Nome a ser pesquisado. Quanto mais detalhes tiver no nome, melhor será a busca.
     * @return array Retorna lista de informações dos usuários.
     */
    public function pesquisarPorNome($nome){
        $this->usuario->setNome($nome);
        
        return $this->usuario->obter();
    }
    
    /**
     * Retorna as informações dos usuários com a situação citada.
     * 
     * @param string $situacao Situação desejada na busca.
     * @return array Retorna lista de informações dos usuários.
     */
    public function obterPorSituacao($situacao){
        $this->usuario->setSituacao($situacao);
        
        return $this->usuario->obter();
    }
}