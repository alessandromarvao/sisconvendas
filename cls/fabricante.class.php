<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es das empresas fabricantes de m�veis no Banco de Dados.
 * Armazena as informa��es dos fabricantes (c�digo, nome da empresa e telefone) para
 * facilitar o contato com os mesmos.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Fabricante {    
     /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel que recebe o c�digo da empresa no Sistema.
     * @access private
     * @var int
     */
    private $id;
    
    /**
     * Vari�vel que recebe o nome da empresa no Sistema.
     * @access private
     * @var string
     */
    private $empresa;
    
    /**
     * Vari�vel que recebe o nome do contato da empresa no Sistema.
     * @access private
     * @var string
     */
    private $contato;
    
    /**
     * Vari�vel que recebe o telefone da empresa no Sistema.
     * @access private
     * @var string
     */
    private $telefone;
    
    /**
     * Vari�vel que recebe o celular corporativo da empresa no Sistema.
     * @access private
     * @var string
     */
    private $celular;
    
    /**
     * Vari�vel que recebe o nome do representante da empresa no Sistema.
     * @access private
     * @var string
     */
    private $representante;
    
    /**
     * Vari�vel que recebe o celular do representante da empresa no Sistema.
     * @access private
     * @var string
     */
    private $cel1Representante;
    
    /**
     * Vari�vel que recebe o celular do representante da empresa no Sistema.
     * @access private
     * @var string
     */
    private $cel2Representante;
    
    /**
     * Inicia as opera��es relacionadas � empresa fornecedora no BD.
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
     * Inicia o objeto j� com o c�digo do fornecedor setado.
     * 
     * @param int $id C�digo do fornecedor.
     */
    function __construct1($id){
        $this->id = (int) $id;
    }
    
    /**
     * Retorna o valor da vari�vel desejada.
     * 
     * @param string $nome Vari�vel desejada.
     * @return string Retorna a informa��o da vari�vel desejada.
     */
    public function __get($nome) {
        return $this->$nome;
    }
    
    /**
     * Armazena o c�digo da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param int $valor C�digo da empresa fabricante de m�veis.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }
    
    /**
     * Armazena o nome da empresa fornecedora de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor Nome da empresa fabricante de m�veis.
     * @return void
     */
    public function setEmpresa($valor){
        $this->empresa = $valor;
    }
    
    /**
     * Armazena o nome do contato do fornecedor na vari�vel id.
     * 
     * @access public
     * @param string $valor Nome da empresa fabricante de m�veis.
     * @return void
     */
    public function setContato($valor){
        $this->contato = $valor;
    }
    
    /**
     * Armazena o telefone da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor Telefone da empresa fabricante de m�veis.
     * @return void
     */
    public function setTelefone($valor){
        $this->telefone = $valor;
    }
    
    /**
     * Armazena o celular do representante da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor N�mero do celular do representante da empresa fabricante de m�veis.
     * @return void
     */
    public function setCelular($valor){
        $this->celular = $valor;
    }
    
    /**
     * Armazena o nome do representante da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor N�mero do celular do representante da empresa fabricante de m�veis.
     * @return void
     */
    public function setRepresentante($valor){
        $this->representante = $valor;
    }
    
    /**
     * Armazena o celular do representante da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor N�mero do celular do representante da empresa fabricante de m�veis.
     * @return void
     */
    public function setCel1Representante($valor){
        $this->cel1Representante = $valor;
    }
    
    /**
     * Armazena o celular do representante da empresa fabricante de m�veis na vari�vel id.
     * 
     * @access public
     * @param string $valor N�mero do celular do representante da empresa fabricante de m�veis.
     * @return void
     */
    public function setCel2Representante($valor){
        $this->cel2Representante = $valor;
    }
    
    private function isIdOk(){
        if(isset($this->id) && $this->id!==0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena ou altera (se o c�digo do fornecedor for citado) as informa��es do fabricante de m�veis no Banco de Dados.
     * 
     * @access public
     * @param int $id C�digo da empresa fornecedora. (DIGITE 0 PARA CADASTRAR NOVO FORNECEDOR).
     * @param string $empresa Nome fantasia da empresa fornecedora.
     * @param string $contato Nome do contato da empresa fornecedora.
     * @param string $telefone Telefone fixo da empresa fornecedora.
     * @param string $celular Telefone celuar da empresa fornecedora.
     * @param string $representante Representante comercial da empresa fornecedora.
     * @param string $cel1_representante Telefone celular do representante  da empresa fornecedora.
     * @param string $cel2_representante Telefone celular do representante  da empresa fornecedora.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($id, $empresa, $contato, $telefone, $celular, $representante, $cel1_representante, $cel2_representante){
        $this->id = (int) $id;
        $this->empresa = $empresa;
        $this->contato = $contato;
        $this->telefone = $telefone;
        $this->celular = $celular;
        $this->representante = $representante;
        $this->cel1Representante = $cel1_representante;
        $this->cel2Representante = $cel2_representante;
        
        if($this->isIdOk()){
            $stmt = $this->conexao->prepare("UPDATE fabricante SET empresa=?, contato=?, tel_empresa=?, cel_empresa=?, representante=?, cel1_representante=?, cel2_representante=? WHERE id_fabricante=?");
            $stmt->bindParam(1, $this->empresa);
            $stmt->bindParam(2, $this->contato);
            $stmt->bindParam(3, $this->telefone);
            $stmt->bindParam(4, $this->celular);
            $stmt->bindParam(5, $this->representante);
            $stmt->bindParam(6, $this->cel1Representante);
            $stmt->bindParam(7, $this->cel2Representante);
            $stmt->bindParam(8, $this->id);
        } else {
            $query = "INSERT INTO fabricante(empresa, contato, tel_empresa, cel_empresa, representante, cel1_representante, cel2_representante) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->empresa);
            $stmt->bindParam(2, $this->contato);
            $stmt->bindParam(3, $this->telefone);
            $stmt->bindParam(4, $this->celular);
            $stmt->bindParam(5, $this->representante);
            $stmt->bindParam(6, $this->cel1Representante);
            $stmt->bindParam(7, $this->cel2Representante);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Deleta do Banco de Dados as informa��es da empresa fabricante de m�veis selecionada.
     * N�o poder� ser deletado do Banco de Dados a empresa que j� realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if($this->isIdOk()){
            $stmt = $this->conexao->prepare("DELETE FROM fabricante WHERE id_fabricante=?");
            $stmt->bindParam(1, $this->id);
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados da(s) empresa(s) fabricante(s) de m�veis no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informa��es da(s) empresa(s)
     */
    public function obter(){
        $query = "SELECT id_fabricante, empresa, contato, tel_empresa, cel_empresa, representante, cel1_representante, cel2_representante FROM fabricante";
        
        if($this->isIdOk()){
            $query .= " WHERE id_fabricante=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->empresa)){
            $empresa = "%" . $this->empresa . "%";
            $query .= " WHERE empresa LIKE ? ORDER BY empresa ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $empresa);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
        } elseif(isset($this->representante)){
            $representante = "%" . $this->representante . "%";
            $query .= " WHERE representante LIKE ? ORDER BY empresa ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $representante);
            $stmt->execute();
            
            return $stmt->fetchALL(PDO::FETCH_ASSOC);
            
        } else {
            $query .= " ORDER BY empresa ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
