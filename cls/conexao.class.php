<?php

include_once 'constantesBD.php';

/**
 * Esta classe cria a conexão com o Banco de Dados usando o PDO, 
 * que fornece seguranãa e também cria pools de conexão para administrar
 * o tráfego de informações no Banco de Dados
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 1.0
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Conexao {
    
    
    /**
     * Retorna um objeto da classe PDO já com as informações
     * necessárias à ligação com o Banco de Dados
     * 
     * @access public
     * @return PDO retorna um objeto PDO
     */
    public static function conectar(){
        try {
            // Mudei o CharSet que era utf8 para Latin1, para aceitar a acentua��o do PT-BR
            $conn = new PDO('mysql:host=' . HST . ';dbname=' . BD . ';charset=Latin1', USR, PWD);
        } catch (Exception $ex) {
            print_r("Erro ao conectar com o Banco de Dados. " . $ex->getMessage());
        }
        return $conn;
    }
}
