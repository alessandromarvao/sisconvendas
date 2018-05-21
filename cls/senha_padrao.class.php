<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe que designa uma senha padrão a ser utilizada na
 * autenticação do usuário no Sistema de Controle de Estoque e Vendas.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Senha_padrao{
    /**
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Variável armazena o código da senha padrão.
     *
     * @var String
     * @access private
     */
    private $id;
    
    /**
     * Variável armazena a data de criação da senha padrão.
     *
     * @var String
     * @access private
     */
    private $data_criacao;
    
    /**
     * Variável que armazena a senha padrão já codificada pelo algoritmo MD5.
     *
     * @var String
     * @access private
     */
    private $padrao;
    
    /**
     * Variável que armazena a senha padrão sem codificação.
     *
     * @var String
     * @access private
     */
    private $padrao_decodificado;
    
    /**
     * Classe que realiza as operações na(s) senha(s) padrão(ões).
     * Pode retornar a senha codificada e sem codificação.
     * 
     * @return void
     */
    function __construct() {
        //Inicia a conexão com o Banco de Dados.
        $this->conexao = Conexao::conectar();
    }
    
    /**
     * Armazena a senha padrão (sem a codificação) na variável.
     * 
     * @access public
     * @param string $valor Senha padrão sem codificação.
     * @return void
     */
    public function setPadraoDecodificado($valor){
        $this->padrao_decodificado = strtolower($valor);
    }
    
    /**
     * Armazena o código da senha padrão na variável.
     * 
     * @access public
     * @param int $valor Código da senha padrão.
     * @return void
     */
    public function setId($valor){
        $this->id = (int) $valor;
    }

    /**
     * Armazena a senha padrão para o BD. Retorna TRUE ou FALSE.
     * 
     * @access public
     * @param int $id Código da senha padrão. DIGITE 0 PARA SALVAR.
     * @param string $padrao Senha padrão sem codificação.
     * @return bool Retorna TRUE se a operação ocorreu com sucesso e 
     * FALSE se houve alguma falha na operação com o BD.
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
     * Remove uma senha padrão do BD. SÓ DEVE SER USADA
     * SE A INFORMAÇÃO DESEJADA JÁ ESTIVER ARMAZENADA NO BD. CASO NEGATIVO, PODE
     * CAUSAR FALHAS NO BD. Retorna TRUE ou FALSE
     * 
     * @access public
     * @param String $data_criacao
     * @return bool Retorna TRUE se a operação ocorreu com sucesso e 
     * FALSE se houve alguma falha na operação com o BD.
     */
    public function remover() {
        $this->data_criacao = $this->obterUltimaData();
        $stmt = $this->conexao->prepare('DELETE FROM senha_padrao WHERE data_criacao=?');
        $stmt->bindParam(1, $this->data_criacao);

        return $stmt->execute();
    }

    /**
     * Consulta as senhas padrões armazenadas no Banco de Dados.
     * 
     * @access public
     * @return array Retorna uma lista contendo todas as senhas 
     * padrões cadastradas no Sistema.
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