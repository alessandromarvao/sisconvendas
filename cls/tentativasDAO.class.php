<?php
include_once 'tentativas.class.php';
include_once 'usuarioDAO.class.php';

/**
 * Classe relacionada � quantidade de falhas nas tentativas de autentica��o do usu�rio
 * no Sistema.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */
class TentativasDAO {
    /**
     * Vari�vel que recebe o objeto da classe Tentativas.
     *
     * @access private
     * @var Object 
     */
    private $tentativas;
    
    /**
     * Inicia as opera��es da tentativa de acesso de um usu�rio ao Sistema no BD.
     * 
     * @return void
     */
    function __construct() {
        $this->tentativas = new Tentativas();
    }
    
    public function salvar($login){
        $this->tentativas->setUsuario($login);
        
        return $this->tentativas->salvar();
    }
    
    /**
     * Apaga dos registros todas as tentativas de login de um usu�rio em um dia espec�fico.
     * 
     * @param string $login Login do usu�rio desejado.
     * @param string $data Data desejada.
     * @return boolean Retorna TRUE se a opera��o for realizada com sucesso e
     * FALSE se ocorrer alguma falha.
     */
    public function removerTentativasDoDia($login){
        $this->tentativas->setUsuario($login);
        
        $resultado = $this->tentativas->obterTentativasDiariasPorUsuario();
        $i = 0;
        $total = $this->tentativas->obterContagemDiariaPorUsuario($login, date('Y-m-d'));
        foreach ($resultado as $linha){
            $this->tentativas->setId($linha['id_tentativas']);
            if($this->tentativas->remover()){
                $i++;
            }
        }        
        if($i==$total){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Retorna a quantidade de tentativas falhas de um usu�rio em um dia espec�fico.
     * 
     * @param string $login Login do usu�rio desejado.
     * @param string $data Data desejada.
     */
    public function obterTentativasDoDia($login, $data){        
        return $this->tentativas->obterContagemDiariaPorUsuario($login, $data);
    }
}