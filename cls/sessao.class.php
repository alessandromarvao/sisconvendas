<?php
// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe que realiza todas as opera��es relacionadas � Sess�o
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class Sessao {
    /**
     * Inicia a sess�o 
     */
    function __construct() {
        if(!isset($_SESSION)){
            session_cache_expire(1);
            session_start();
        }
    }
    
    /**
     * Salva o valor no seu devido atributo na sess�o.
     * 
     * @access public
     * @param string $nome
     * @param string $valor
     */
    private function salvar($nome, $valor){
        if(isset($nome)){
            $_SESSION[$nome] = $valor;
        }
    }
    
    /**
     * Retorna o valor desejado na sess�o.
     * 
     * @param string $nome Nome da vari�vel na sess�o a ser pesquisada.
     * @return string Retorna o valor na sess�o determinada.
     */
    private function obter($nome){
        if(isset($nome)){
            return $_SESSION[$nome];
        } else {
            return NULL;
        }
    }
    
    /**
     * Elimina todos os dados armazenados na sess�o e a encerra.
     */
    public function destroy(){
        session_destroy();
        session_unset();
        unset($_SESSION);
    }
    
    /**
     * Confere os valores do STATUS na sess�o para logar no Sistema e retorna a condi��o.
     * no_user -> Usu�rio e senha incorretos.
     * no_pwd -> Usu�rio existe, mas senha incorreta.
     * ok -> Login validado.
     * 
     * @return int Retorna 0 se o usu�rio e senha estiverem incorretos,
     * 1 se a senha estiver incorreta,
     * 2 se a valida��o ocorrer com sucesso e
     * 3 se n�o hover dados inseridos.
     */
    public function validaLogin(){
        if($this->issetSessao('status')){
            if(strcmp($this->getStatus(), 'no_user')==0){ 
                return 0;
            } elseif(strcmp($this->getStatus(), 'no_pwd')==0){
                return 1;
            }elseif(strcmp($this->getStatus(), 'ok')==0) {
                return 2;
            } else {
                return 0;
            }
        } else {
            return 3;
        }
    }
    
    /**
     * Confere se a vari�vel existe na sess�o.
     * 
     * @param string $nome Nome desejado a ser pesquisado.
     * @return boolean Retorna TRUE se a vari�vel existe na sess�o e FALSE se n�o.
     */
    public function issetSessao($nome){
        return isset($_SESSION[$nome]);
    }
    
    /**
     * Apaga um registro determinado da sess�o.
     * 
     * @param string $nome Nome da vari�vel a ser deletada da sess�o.
     */
    private function apagarDaSessao($nome){
        unset($_SESSION[$nome]);
    }
    
    /**
     * Retorna o valor do STATUS na sess�o.
     * 
     * @return string Valor do STATUS na sess�o.
     */
    public function getStatus(){
        return $this->obter('status');
    }
    
    /**
     * Define um valor para STATUS na sess�o.
     * no_user -> Usu�rio e senha incorretos.
     * no_pwd -> Usu�rio existe, mas senha incorreta.
     * ok -> Login validado.
     * 
     * @param string $valor Valor a ser definido no STATUS.
     */
    public function setStatus($valor){
        $this->salvar('status', $valor);
    }
    
    /**
     * Retorna o valor do BLOQUEIO DO USU�RIO na sess�o.
     * 
     * @return string Valor do BLOQUEIO na sess�o.
     */
    public function getBloquearUsuario(){
        return $this->obter('block');
    }
    
    /**
     * Define um valor para STATUS na sess�o.
     * 
     * @param string $valor Valor a ser definido no BLOQUEIO (TRUE e FALSE).
     */
    public function setBloquearUsuario($valor){
        $this->salvar('block', $valor);
    }
    
    /**
     * Retorna o valor do SITUA��O DO USU�RIO na sess�o.
     * 
     * @return string Valor da SITUA��O na sess�o.
     */
    public function getSituacao(){
        return $this->obter('situacao');
    }
    
    /**
     * Define um valor para STATUS na sess�o.
     * 
     * @param string $valor Valor a ser definido no SITUA��O (ativo e bloqueado).
     */
    public function setSituacao($valor){
        $this->salvar('situacao', $valor);
    }
    
    /**
     * Retorna o valor do FUNCAO na sess�o.
     * 
     * @return string Valor da FUNC�O na sess�o.
     */
    public function getFuncao(){
        return $this->obter('funcao');
    }
    
    /**
     * Define um valor para FUNCAO na sess�o.
     * 
     * @param string $valor Valor a ser definido na FUN��O.
     */
    public function setFuncao($valor){
        $this->salvar('funcao', $valor);
    }
    
    /**
     * Retorna o valor do NOME na sess�o.
     * 
     * @return string Valor do NOME na sess�o.
     */
    public function getNome(){
        return $this->obter('nome');
    }
    
    /**
     * Define um valor para NOME na sess�o.
     * 
     * @param string $valor Valor a ser definido no NOME.
     */
    public function setNome($valor){
        $this->salvar('nome', $valor);
    }
    
    /**
     * Retorna o valor do LOGIN na sess�o.
     * 
     * @return string Valor do LOGIN na sess�o.
     */
    public function getLogin(){
        return $this->obter('login');
    }
    
    /**
     * Define um valor para LOGIN na sess�o.
     * 
     * @param string $valor Valor a ser definido no LOGIN.
     */
    public function setLogin($valor){
        $this->salvar('login', $valor);
    }
    
    /**
     * Retorna o valor do CLIENTE na sess�o.
     * 
     * @return string Valor do CLIENTE na sess�o.
     */
    public function getCliente(){
        return base64_decode($this->obter('cliente'));
    }
    
    /**
     * Define um valor para CLIENTE na sess�o.
     * 
     * @param string $valor Valor a ser definido no CLIENTE.
     */
    public function setCliente($valor){
        $this->salvar('cliente', $valor);
    }
    
    public function getVenda(){
        return $this->obter('venda');
    }
    
    public function setVenda($valor){
        $this->salvar('venda', $valor);
    }
    
    /**
     * Retorna o valor do ENDERECO na sess�o.
     * 
     * @return string Valor do ENDERECO na sess�o.
     */
    public function getEndereco(){
        return $this->obter('endereco');
    }
    
    /**
     * Retorna o valor da REFERENCIA na sess�o.
     * 
     * @return string Valor da REFERENCIA na sess�o.
     */
    public function getReferencia(){
        return $this->obter('referencia');
    }
    
    /**
     * Define um valor para ENDERECO na sess�o.
     * 
     * @param string $valor Valor a ser definido no ENDERECO.
     */
    public function setEndereco($valor){
        $this->salvar('endereco', $valor);
    }
    
    /**
     * 
     * @param string $valor Valor a ser definido na REFERENCIA.
     */
    public function setReferencia($valor){
        $this->salvar('referencia', $valor);
    }
    
    /**
     * Apaga o registro do dliente da sess�o.
     */
    public function limparCliente(){
        $this->apagarDaSessao("cliente");
    }
    
    public function situacaoOK(){
        if($this->validaLogin()==2 && strcmp($this->getSituacao(), 'ativo')==0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
