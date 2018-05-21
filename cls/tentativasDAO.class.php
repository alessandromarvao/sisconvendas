<?php
include_once 'tentativas.class.php';
include_once 'usuarioDAO.class.php';

/**
 * Classe relacionada à quantidade de falhas nas tentativas de autenticação do usuário
 * no Sistema.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */
class TentativasDAO {
    /**
     * Variável que recebe o objeto da classe Tentativas.
     *
     * @access private
     * @var Object 
     */
    private $tentativas;
    
    /**
     * Inicia as operações da tentativa de acesso de um usuário ao Sistema no BD.
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
     * Apaga dos registros todas as tentativas de login de um usuário em um dia específico.
     * 
     * @param string $login Login do usuário desejado.
     * @param string $data Data desejada.
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e
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
     * Retorna a quantidade de tentativas falhas de um usuário em um dia específico.
     * 
     * @param string $login Login do usuário desejado.
     * @param string $data Data desejada.
     */
    public function obterTentativasDoDia($login, $data){        
        return $this->tentativas->obterContagemDiariaPorUsuario($login, $data);
    }
}