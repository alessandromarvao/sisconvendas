<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es dos clientes da empresa no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Cliente {
     /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o CPF do cliente.
     * 
     * @var string
     * @access private
     */
    private $cpf;
    
    /**
     * Vari�vel que recebe o nome do cliente.
     * 
     * @var string
     * @access private
     */
    private $nome;
    
    /**
     * Vari�vel que recebe a data de nascimento do cliente.
     * 
     * @var string
     * @access private
     */
    private $dataNascimento;
    
    /**
     * Vari�vel que recebe o email do cliente.
     * 
     * @var string
     * @access private
     */
    private $email;
    
    /**
     * Vari�vel que recebe o endere�o do cliente.
     * 
     * @var string
     * @access private
     */
    private $endereco;
    
    /**
     * Vari�vel que recebe o bairro que o cliente reside.
     * 
     * @var string
     * @access private
     */
    private $bairro;
    
    /**
     * Vari�vel que recebe o ponto de refer�ncia do endere�o do cliente.
     * 
     * @var string
     * @access private
     */
    private $referencia;
    
    /**
     * Vari�vel que recebe o CEP do cliente.
     * 
     * @var string
     * @access private
     */
    private $cep;
    
    /**
     * Vari�vel que recebe o n�mero do telefone fixo do cliente com DDD.
     * 
     * @var string
     * @access private
     */
    private $telefone;
    
    /**
     * Vari�vel que recebe o n�mero do telefone celular do cliente com DDD.
     * 
     * @var string
     * @access private
     */
    private $celular1;
    
    /**
     * Vari�vel que recebe o n�mero do telefone celular do cliente com DDD.
     * 
     * @var string
     * @access private
     */
    private $celular2;
    
    /**
     * Inicia as opera��es de autentica��o do Usu�rio do Sistema no BD.
     * Retorna o login do usu�rio e a senha codificada.
     * 
     * @return void
     */
    function __construct() {
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com par�metros, encaminha ao construtor desejado
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }
    
    /**
     * Inicia o objeto de Cliente j� com o cpf setado.
     * 
     * @param string $cpf
     */
    function __construct1($cpf){
        $this->cpf = $cpf;
    }
    
    /**
     * Armazena o CPF do cliente na vari�vel. CAMPO OBRIGAT�RIO.
     * 
     * @access public
     * @param string $valor CPF do cliente.
     * @return void
     */
    public function setCPF($valor){
        $this->cpf = $valor;
    }
    
    /**
     * Armazena o nome do cliente na vari�vel. CAMPO OBRIGAT�RIO.
     * 
     * @access public
     * @param string $valor Nome do cliente.
     * @return void
     */
    public function setNome($valor){
        $this->nome = strtoupper($valor);
    }
    
    /**
     * Confere se os campos obrigat�rios est�o preenchidos.
     * 
     * @access private
     * @return boolean Retorna TRUE se todos os campos obrigat�rios est�o preenchidos 
     * e FALSE se h� algum campo obrigat�rio em branco.
     */
    private function camposObrigatoriosOK(){
        if(isset($this->cpf) && isset($this->nome) && isset($this->endereco) && isset($this->bairro) && isset($this->referencia) && isset($this->dataNascimento)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informa��es pessoais do cliente no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($cpf, $nome, $dataNascimento, $email, $end, $bairro, $ref, $cep, $tel, $cel1, $cel2){
        $this->cpf = $cpf;
        $this->nome = strtoupper($nome);
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->endereco = strtoupper($end);
        $this->bairro = strtoupper($bairro);
        $this->referencia = strtoupper($ref);
        $this->cep = $cep;
        $this->telefone = $tel;
        $this->celular1 = $cel1;
        $this->celular2 = $cel2;
        if ($this->camposObrigatoriosOK()){
            $stmt = $this->conexao->prepare('INSERT INTO cliente VALUES (?,?,?,?,?,?,?,?,?,?,?)');
            $stmt->bindParam(1, $this->cpf);
            $stmt->bindParam(2, $this->nome);
            $stmt->bindParam(3, $this->dataNascimento);
            $stmt->bindParam(4, $this->email);
            $stmt->bindParam(5, $this->endereco);
            $stmt->bindParam(6, $this->bairro);
            $stmt->bindParam(7, $this->referencia);
            $stmt->bindParam(8, $this->cep);
            $stmt->bindParam(9, $this->telefone);
            $stmt->bindParam(10, $this->celular1);
            $stmt->bindParam(11, $this->celular2);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Modifica as informa��es pessoais do cliente no Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterar($cpf, $nome, $dataNascimento, $email, $end, $bairro, $ref, $cep, $tel, $cel1, $cel2){
        $this->cpf = $cpf;
        $this->nome = strtoupper($nome);
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->endereco = strtoupper($end);
        $this->bairro = strtoupper($bairro);
        $this->referencia = strtoupper($ref);
        $this->cep = $cep;
        $this->telefone = $tel;
        $this->celular1 = $cel1;
        $this->celular2 = $cel2;
        if ($this->camposObrigatoriosOK()){
            $query = 'UPDATE cliente SET nome_cliente=?,data_nasc_cliente=?, email_cliente=?,'
                    . ' endereco=?, bairro=?, pto_referencia=?, cep=?, tel_cliente=?,'
                    . ' cel2_cliente=?, cel1_cliente=? WHERE cpf_cliente=?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->nome);
            $stmt->bindParam(2, $this->dataNascimento);
            $stmt->bindParam(3, $this->email);
            $stmt->bindParam(4, $this->endereco);
            $stmt->bindParam(5, $this->bairro);
            $stmt->bindParam(6, $this->referencia);
            $stmt->bindParam(7, $this->cep);
            $stmt->bindParam(8, $this->telefone);
            $stmt->bindParam(9, $this->celular1);
            $stmt->bindParam(10, $this->celular2);
            $stmt->bindParam(11, $this->cpf);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta do Banco de Dados as informa��es do cliente selecionado.
     * N�o poder� ser deletado do Banco de Dados o cliente que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if(isset($this->cpf)){
            $stmt = $this->conexao->prepare("DELETE FROM cliente WHERE cpf_cliente=?");
            $stmt->bindParam(1, $this->cpf);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados do(s) cliente(s) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informa��es do(s) cliente(s)
     */
    public function obter(){
        $query = "SELECT cpf_cliente, nome_cliente, data_nasc_cliente, email_cliente, endereco, bairro, pto_referencia,"
                . " cep, tel_cliente, cel1_cliente, cel2_cliente, data_nasc_cliente FROM cliente";
        
        if(isset($this->cpf)){
            $query .= " WHERE cpf_cliente=? ORDER BY nome_cliente ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cpf);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->nome)){   //obter por nome
            $nome = "%" . $this->nome . "%";
            $query .= " WHERE nome_cliente LIKE ? ORDER BY nome_cliente ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $nome);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif(isset($this->bairro)) {    //obter por bairro
            $bairro = "%" . $this->bairro . "%";
            $query .= " WHERE bairro LIKE ? ORDER BY nome_cliente ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $bairro);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query .= " ORDER BY nome_cliente ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna lista de informa��es de um cliente desejado.
     * 
     * @return array Retorna lista de informa��es de um cliente selecionado. Se o CPF n�o for encontrado, retorna NULL.
     */
    public function obterUnidadePorCPF(){
        if(!empty($this->cpf)){
            $query = "SELECT cpf_cliente, nome_cliente, data_nasc_cliente, email_cliente, endereco, bairro, "
                    . "pto_referencia, cep, tel_cliente, cel1_cliente, cel2_cliente FROM"
                    . " cliente WHERE cpf_cliente=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->cpf);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return NULL;
        }
    }
    
    /**
     * Retorna as informa��es dos clientes que aniversariam no m�s corrente.
     * 
     * return array informa��es dos clientes.
     */
    public function obterAniversariantesDoMes(){
        $query = "SELECT cpf_cliente, nome_cliente, email_cliente, tel_cliente, cel1_cliente, cel2_cliente, endereco, bairro, data_nasc_cliente"
                . " FROM cliente WHERE MONTH(CURDATE())=MONTH(data_nasc_cliente) ORDER BY nome_cliente ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna as informa��es dos clientes que aniversariam no dia corrente.
     * 
     * return array informa��es dos clientes.
     */
    public function obterAniversariantesDoDia(){
        $query = "SELECT cpf_cliente, nome_cliente, email_cliente, tel_cliente, cel1_cliente, cel2_cliente, endereco, bairro, data_nasc_cliente"
                . " FROM cliente WHERE MONTH(CURDATE())=MONTH(data_nasc_cliente) AND day(curdate())=day(data_nasc_cliente) ORDER BY nome_cliente ASC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
