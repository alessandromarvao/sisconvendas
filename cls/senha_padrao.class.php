<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe que designa uma senha padr�o a ser utilizada na
 * autentica��o do usu�rio no Sistema de Controle de Estoque e Vendas.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Senha_padrao{
    /**
     * Vari�vel que inicia a conex�o com o BD e realiza as opera��es no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Vari�vel armazena o c�digo da senha padr�o.
     *
     * @var String
     * @access private
     */
    private $id;
    
    /**
     * Vari�vel armazena a data de cria��o da senha padr�o.
     *
     * @var String
     * @access private
     */
    private $data_criacao;
    
    /**
     * Vari�vel que armazena a senha padr�o j� codificada pelo algoritmo MD5.
     *
     * @var String
     * @access private
     */
    private $padrao;
    
    /**
     * Vari�vel que armazena a senha padr�o sem codifica��o.
     *
     * @var String
     * @access private
     */
    private $padrao_decodificado;
    
    /**
     * Classe que realiza as opera��es na(s) senha(s) padr�o(�es).
     * Pode retornar a senha codificada e sem codifica��o.
     * 
     * @return void
     */
    function __construct() {
        //Inicia a conex�o com o Banco de Dados.
        $this->conexao = Conexao::conectar();
    }
    
    /**
     * Armazena a senha padr�o (sem a codifica��o) na vari�vel.
     * 
     * @access public
     * @param string $valor Senha padr�o sem codifica��o.
     * @return void
     */
    public function setPadraoDecodificado($valor){
        $this->padrao_decodificado = strtolower($valor);
    }
    
    /**
     * Armazena o c�digo da senha padr�o na vari�vel.
     * 
     * @access public
     * @param int $valor C�digo da senha padr�o.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }

    /**
     * Armazena a senha padr�o para o BD. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param int $id C�digo da senha padr�o. DIGITE 0 PARA SALVAR.
     * @param string $padrao Senha padr�o sem codifica��o.
     * @return bool Retorna TRUE se a opera��o ocorreu com sucesso e 
     * FALSE se houve alguma falha na opera��o com o BD.
     */
    public function salvar($id, $padrao) {
        $this->id = (int) $id;
        $this->padrao_decodificado = strtolower($padrao);
        $this->data_criacao = date('Y-m-d');
        $this->padrao = md5($this->padrao_decodificado);
        
        if(isset($this->id)){
            $stmt = $this->conexao->prepare("UPDATE senha_padrao SET padrao=?, padrao_decod=?, data_criacao=? WHERE id_padrao=?");
            $stmt->bindParam(1, $this->padrao);
            $stmt->bindParam(2, $this->padrao_decodificado);
            $stmt->bindParam(3, date('Y-m-d'));
            $stmt->bindParam(4, $this->id);

            return $stmt->execute();
        } else {
            $stmt = $this->conexao->prepare("INSERT INTO senha_padrao VALUES ('', ?, ?, ?)");
            $stmt->bindParam(1, $this->padrao);
            $stmt->bindParam(2, $this->padrao_decodificado);
            $stmt->bindParam(3, $this->data_criacao);

            return $stmt->execute();
        }
    }

    /**
     * Remove uma senha padr�o do BD. S� DEVE SER USADA
     * SE A INFORMA��O DESEJADA J� ESTIVER ARMAZENADA NO BD. CASO NEGATIVO, PODE
     * CAUSAR FALHAS NO BD. Retorna TRUE ou FALSE
     * 
     * @access public
     * @param String $data_criacao
     * @return bool Retorna TRUE se a opera��o ocorreu com sucesso e 
     * FALSE se houve alguma falha na opera��o com o BD.
     */
    public function remover() {
        $this->data_criacao = $this->obterUltimaData();
        $stmt = $this->conexao->prepare('DELETE FROM senha_padrao WHERE data_criacao=?');
        $stmt->bindParam(1, $this->data_criacao);

        return $stmt->execute();
    }

    /**
     * Consulta as senhas padr�es armazenadas no Banco de Dados.
     * 
     * @access public
     * @return array Retorna uma lista contendo todas as senhas 
     * padr�es cadastradas no Sistema.
     */
    public function obter() {
        $query = "SELECT id_padrao, padrao, padrao_decod, data_criacao FROM senha_padrao";
        if(isset($this->padrao_decodificado)){
            $query .= " WHERE padrao_decod=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->padrao_decodificado);
        } else {
            $stmt = $this->conexao->prepare($query);
        }
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}