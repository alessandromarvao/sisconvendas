<?php


/**
 * Esta classe trabalha com todas as codificações a serem utilizadas na classe
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Codificacao {
    /**
     * Variável que recebe uma palavra.
     * 
     * @access private
     * @var String
     */
    private $palavra;
    /**
     * Variável que recebe uma chave a 
     * ser codificada usando o algoritmo MD5.
     * 
     * @access private
     * @var String
     */
    private $chave;
    /**
     * Variável que recebe uma data no padrão 
     * norte-americano e o converte para o padrão brasileiro.
     * 
     * @access private
     * @var String
     */
    private $data;
    
    /**
     * Função que recebe os parâmetros de uma palavra.
     * 
     * @access public
     * @param String $valor
     * @return void
     */
    public function setPalavra($valor){
        $this->palavra = $valor;
    }
    
    /**
     * Retorna a chave criptografada em MD5
     * 
     * @access public
     * @return string Chave criptografada pelo algoritmo MD5
     */
    public function getChave(){
        return $this->chave;
    }
    
    /**
     * Função que recebe os parâmetros da palavra 
     * que será codificada utilizando o algorítmo MD5.
     * 
     * @access public
     * @param String $valor
     * @return void
     */
    public function setChave($valor){
        $this->chave = md5($valor);
    }
    
    /**
     * Função que recebe os parâmetros da data que se encontra no padrão norte-americano.
     * 
     * @access public
     * @param String $valor
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Função que retorna a palavra sem os caracteres especiais.
     * 
     * @access public
     * @return String Retorna a palavra selecionada sem os caracteres especiais.
     */
    public function alfanumerico(){
        return preg_replace('/[^[:alnum:]_]/', '', $this->palavra);
    }
    
    /**
     * Função que compara se duas palavras são iguais.
     * Retorna TRUE se positivo. Retorna FALSE se não.
     * 
     * @access public
     * @param String $outraPalavra
     * @return bool Retorna TRUE se as duas palavras são iguais. Se não, retorna FALSE.
     */
    public function palavrasIguais($outraPalavra) {
        if(strcmp($this->palavra, $outraPalavra) == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Função que recebe uma data no padrão norte-americana (AAAA-MM-DD) 
     * e a converte para o padrão brasileiro (DD/MM/AAAA).
     * Exemplo: converte 1986-09-16 para 16/09/1986
     * 
     * @access public
     * @return String Retorna a data no padrão DD/MM/AAAA.
     */
    public function mudarPadraoData() {
        return date('d/m/Y', strtotime($this->data));
    }
}