<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada � quantidade de falhas nas tentativas de autentica��o do usu�rio
 * no Sistema.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Tentativas {
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
      * Vari�vel que armazena o c�digo da tentativa de autentica��o do usu�rio ao Sistema.
      * 
      * @var int C�digo da tentativa
      * @access private
      */
    private $id;
    
    /**
     * Vari�vel que armazena o login do usu�rio do Sistema.
     * 
     * @var string Login do usu�rio
     * @access private
     */
    private $usuario;
    
    /**
     * Vari�vel que armazena a data da tentativa de acesso atual.
     *
     * @var string Data da tentativa atual
     * @access private
     */
    private $data;
    
    /**
     * Vari�vel que armazena a hora da tentativa de acesso atual.
     *
     * @var string Hora da tentativa atual
     * @access private
     */
    private $hora;
    
    /**
     * Inicia as opera��es da tentativa de acesso ao Sistema no BD.
     * 
     * @return void
     */
    function __construct() {
        $conexao = new Conexao();
        $this->conexao = $conexao->conectar();
        date_default_timezone_set('America/Recife');
    }
    
    /**
     * Vari�vel m�gica, pode retornar a vari�vel citada no par�metro.
     * 
     * @access public
     * @param String $nome Nome da vari�vel que voc� deseja obter informa��o.
     * @return String
     */
    public function __get($nome){
        return $this->$nome;
    }
    
    /**
     * Armazena um valor � vari�vel Id.
     * 
     * @access public
     * @param int $valor C�digo da tentativa atual.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }
    
    /**
     * Armazena um valor � vari�vel usuario
     * 
     * @access public
     * @param string $valor Login do usu�rio.
     * @return void
     */
    public function setUsuario($valor){
        $this->usuario = $valor;
    }
    
    /**
     * Armazena um valor � vari�vel data.
     * @access public
     * @param string $valor Data da tentativa.
     * @return void 
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Armazena um valor � vari�vel hora.
     * @access public
     * @param string $valor Hora da tentativa.
     * @return void 
     */
    public function setHora($valor){
        $this->hora = $valor;
    }
    
    /**
     * Armazena as informa��es da falha na tentativa de acesso do usu�rio no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e
     * FALSE se ocorrer alguma falha.
     */
    public function salvar(){
        if(isset($this->usuario)){
            $data = date('Y-m-d');
            $hora = date('H:i:s');
            $stmt = $this->conexao->prepare("INSERT INTO tentativas VALUES('', ?, ?, ?)");
            $stmt->bindParam(1, $this->usuario);
            $stmt->bindParam(2, $data);
            $stmt->bindParam(3, $hora);
            
//            echo "INSERT INTO tentativas VALUES ('', '$this->usuario', '$data', '$hora');";
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Deleta a tentativa desejada do Banco de Dados.
     * 
     * @access public
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e
     * FALSE se ocorrer alguma falha.
     */
    public function remover(){
        if(isset($this->id) && $this->id>0){
            $stmt = $this->conexao->prepare("DELETE FROM tentativas WHERE id_tentativas=?");
            $stmt->bindParam(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisa tentativas de autentica��o do(s) usu�rio(s) no Sistema de acordo com o exigido 
     * (por id de tentativas, por login do usu�rio, por data ou buscar todos os registros).
     * 
     * @access public
     * @return array[] Retorna lista de tentativas de acordo com o selecionado.
     */
    public function obter(){
        $query = "SELECT id_tentativas, login_FK, data, hora FROM tentativas";
        if(isset($this->id)){   //obter pelo id_tentativas
            $query .= " WHERE id_tentativas=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->usuario)){    //obter pelo login do usu�rio
            $login = $this->usuario . "%";
            $query .= " WHERE login_FK like ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $login);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif(isset($this->data)){
            $query .= " WHERE data=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->data);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna lista de c�digos de tentativas de logins falhas durante um dia selecionado.
     * 
     * @access public
     * @return array Retorna lista de c�digos de tentativas de logins falhas durante um dia selecionado.
     */
    public function obterTentativasDiariasPorUsuario(){
        if(isset($this->usuario)){
            $stmt = $this->conexao->prepare("SELECT id_tentativas FROM tentativas WHERE login_FK=?");
            $stmt->bindParam(1, $this->usuario);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Pesquisa as tentativas de autentica��o do(s) usu�rio(s)
     * de acordo com um intervalo de data.
     * 
     * @access public
     * @param string $data1 Data inicial.
     * @param string $data2 Data final.
     * @return array[] Retorna lista contendo as informa��es requisitadas.
     */
    public function obterPorIntervaloDeDatas($data1, $data2){
        $query = "SELECT id_tentativas, login_FK, data, hora FROM tentativas WHERE ";
        if(strcmp($data1, $data2)>0){
            $aux = $data1;
            $data1 = $data2;
            $data2 = $aux;
        }
        if(isset($this->usuario)){
            $query .= "login_fk=? AND data BETWEEN ? AND ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->usuario);
            $stmt->bindParam(2, $data1);
            $stmt->bindParam(3, $data2);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query .= "data BETWEEN ? AND ?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $data1);
            $stmt->bindParam(2, $data2);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna a quantidade de tentativas de acessos de um usu�rio em um dia determinado.
     * 
     * @access public
     * @param string $usuario Usu�rio desejado para a busca.
     * @param string $data Data desejada para a busca.
     * @return int Retorna um valor em inteiro quando a pesquisa � bem sucedida
     * e NULL quando h� falha na busca.
     */
    public function obterContagemDiariaPorUsuario($usuario, $data){
        if(!empty($usuario) && !empty($data)){
            $this->usuario = $usuario . "%";
            $query = "SELECT count(id_tentativas) FROM tentativas WHERE login_FK LIKE ? AND data=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->usuario);
            $stmt->bindParam(2, $data);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $resultado['count(id_tentativas)'];
        } else {
            return NULL;
        }
    }
}