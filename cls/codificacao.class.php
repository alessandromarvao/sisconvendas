<?php


/**
 * Esta classe trabalha com todas as codifica��es a serem utilizadas na classe
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class Codificacao {
    /**
     * Vari�vel que recebe uma palavra.
     * 
     * @access private
     * @var String
     */
    private $palavra;
    /**
     * Vari�vel que recebe uma chave a 
     * ser codificada usando o algoritmo MD5.
     * 
     * @access private
     * @var String
     */
    private $chave;
    /**
     * Vari�vel que recebe uma data no padr�o 
     * norte-americano e o converte para o padr�o brasileiro.
     * 
     * @access private
     * @var String
     */
    private $data;
    
    /**
     * Fun��o que recebe os par�metros de uma palavra.
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
     * Fun��o que recebe os par�metros da palavra 
     * que ser� codificada utilizando o algor�tmo MD5.
     * 
     * @access public
     * @param String $valor
     * @return void
     */
    public function setChave($valor){
        $this->chave = md5($valor);
    }
    
    /**
     * Fun��o que recebe os par�metros da data que se encontra no padr�o norte-americano.
     * 
     * @access public
     * @param String $valor
     * @return void
     */
    public function setData($valor){
        $this->data = $valor;
    }
    
    /**
     * Fun��o que retorna a palavra sem os caracteres especiais.
     * 
     * @access public
     * @return String Retorna a palavra selecionada sem os caracteres especiais.
     */
    public function alfanumerico(){
        return preg_replace('/[^[:alnum:]_]/', '', $this->palavra);
    }
    
    /**
     * Fun��o que compara se duas palavras s�o iguais.
     * Retorna TRUE se positivo. Retorna FALSE se n�o.
     * 
     * @access public
     * @param String $outraPalavra
     * @return bool Retorna TRUE se as duas palavras s�o iguais. Se n�o, retorna FALSE.
     */
    public function palavrasIguais($outraPalavra) {
        if(strcmp($this->palavra, $outraPalavra) == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Fun��o que recebe uma data no padr�o norte-americana (AAAA-MM-DD) 
     * e a converte para o padr�o brasileiro (DD/MM/AAAA).
     * Exemplo: converte 1986-09-16 para 16/09/1986
     * 
     * @access public
     * @return String Retorna a data no padr�o DD/MM/AAAA.
     */
    public function mudarPadraoData() {
        return date('d/m/Y', strtotime($this->data));
    }
}