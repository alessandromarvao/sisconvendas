<?php
// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe que realiza todas as operações relacionadas à Sessão
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class Sessao {
    /**
     * Inicia a sessão 
     */
    function __construct() {
        if(!isset($_SESSION)){
            session_cache_expire(1);
            session_start();
        }
    }
    
    /**
     * Salva o valor no seu devido atributo na sessão.
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
     * Retorna o valor desejado na sessão.
     * 
     * @param string $nome Nome da variável na sessão a ser pesquisada.
     * @return string Retorna o valor na sessão determinada.
     */
    private function obter($nome){
        if(isset($nome)){
            return $_SESSION[$nome];
        } else {
            return NULL;
        }
    }
    
    /**
     * Elimina todos os dados armazenados na sessão e a encerra.
     */
    public function destroy(){
        session_destroy();
        session_unset();
        unset($_SESSION);
    }
    
    /**
     * Confere os valores do STATUS na sessão para logar no Sistema e retorna a condição.
     * no_user -> Usuário e senha incorretos.
     * no_pwd -> Usuário existe, mas senha incorreta.
     * ok -> Login validado.
     * 
     * @return int Retorna 0 se o usuário e senha estiverem incorretos,
     * 1 se a senha estiver incorreta,
     * 2 se a validação ocorrer com sucesso e
     * 3 se não hover dados inseridos.
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
     * Confere se a variável existe na sessão.
     * 
     * @param string $nome Nome desejado a ser pesquisado.
     * @return boolean Retorna TRUE se a variável existe na sessão e FALSE se não.
     */
    public function issetSessao($nome){
        return isset($_SESSION[$nome]);
    }
    
    /**
     * Apaga um registro determinado da sessão.
     * 
     * @param string $nome Nome da variável a ser deletada da sessão.
     */
    private function apagarDaSessao($nome){
        unset($_SESSION[$nome]);
    }
    
    /**
     * Retorna o valor do STATUS na sessão.
     * 
     * @return string Valor do STATUS na sessão.
     */
    public function getStatus(){
        return $this->obter('status');
    }
    
    /**
     * Define um valor para STATUS na sessão.
     * no_user -> Usuário e senha incorretos.
     * no_pwd -> Usuário existe, mas senha incorreta.
     * ok -> Login validado.
     * 
     * @param string $valor Valor a ser definido no STATUS.
     */
    public function setStatus($valor){
        $this->salvar('status', $valor);
    }
    
    /**
     * Retorna o valor do BLOQUEIO DO USUÁRIO na sessão.
     * 
     * @return string Valor do BLOQUEIO na sessão.
     */
    public function getBloquearUsuario(){
        return $this->obter('block');
    }
    
    /**
     * Define um valor para STATUS na sessão.
     * 
     * @param string $valor Valor a ser definido no BLOQUEIO (TRUE e FALSE).
     */
    public function setBloquearUsuario($valor){
        $this->salvar('block', $valor);
    }
    
    /**
     * Retorna o valor do SITUAÇÃO DO USUÁRIO na sessão.
     * 
     * @return string Valor da SITUAÇÂO na sessão.
     */
    public function getSituacao(){
        return $this->obter('situacao');
    }
    
    /**
     * Define um valor para STATUS na sessão.
     * 
     * @param string $valor Valor a ser definido no SITUAÇÃO (ativo e bloqueado).
     */
    public function setSituacao($valor){
        $this->salvar('situacao', $valor);
    }
    
    /**
     * Retorna o valor do FUNCAO na sessão.
     * 
     * @return string Valor da FUNCÃO na sessão.
     */
    public function getFuncao(){
        return $this->obter('funcao');
    }
    
    /**
     * Define um valor para FUNCAO na sessão.
     * 
     * @param string $valor Valor a ser definido na FUNÇÃO.
     */
    public function setFuncao($valor){
        $this->salvar('funcao', $valor);
    }
    
    /**
     * Retorna o valor do NOME na sessão.
     * 
     * @return string Valor do NOME na sessão.
     */
    public function getNome(){
        return $this->obter('nome');
    }
    
    /**
     * Define um valor para NOME na sessão.
     * 
     * @param string $valor Valor a ser definido no NOME.
     */
    public function setNome($valor){
        $this->salvar('nome', $valor);
    }
    
    /**
     * Retorna o valor do LOGIN na sessão.
     * 
     * @return string Valor do LOGIN na sessão.
     */
    public function getLogin(){
        return $this->obter('login');
    }
    
    /**
     * Define um valor para LOGIN na sessão.
     * 
     * @param string $valor Valor a ser definido no LOGIN.
     */
    public function setLogin($valor){
        $this->salvar('login', $valor);
    }
    
    /**
     * Retorna o valor do CLIENTE na sessão.
     * 
     * @return string Valor do CLIENTE na sessão.
     */
    public function getCliente(){
        return base64_decode($this->obter('cliente'));
    }
    
    /**
     * Define um valor para CLIENTE na sessão.
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
     * Retorna o valor do ENDERECO na sessão.
     * 
     * @return string Valor do ENDERECO na sessão.
     */
    public function getEndereco(){
        return $this->obter('endereco');
    }
    
    /**
     * Retorna o valor da REFERENCIA na sessão.
     * 
     * @return string Valor da REFERENCIA na sessão.
     */
    public function getReferencia(){
        return $this->obter('referencia');
    }
    
    /**
     * Define um valor para ENDERECO na sessão.
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
     * Apaga o registro do dliente da sessão.
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
