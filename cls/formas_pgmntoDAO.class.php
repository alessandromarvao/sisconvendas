<?php
include_once 'formas_pgmnto.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações relacionadas às formas de 
 * pagamento da venda no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Formas_pgmntoDAO {
    /**
     * Variável que recebe objedo da classe Formas_pgmnto.
     *
     * @var object 
     */
    private $pagamento;
    
    function __construct() {
        $this->pagamento = new Formas_pgmnto();
    }
    
    /**
     * Armazena as informações da forma de pagamento no Banco de Dados.
     * 
     * @access public
     * @param string $formaPgmto Forma de pagamento desejada.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($formaPgmto){
        $this->pagamento->setFormas($formaPgmto);
        
        return $this->pagamento->salvar();
    }
    
    /**
     * Deleta do Banco de Dados as informações da forma de pagamento.
     * Não poderá ser deletada do Banco de Dados a forma de pagamento 
     * que já realizou algum cadastro no Sistema.
     * 
     * @access public
     * @param int $id Código da forma de pagamento.
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover($id){
        $this->pagamento->setId($id);
        
        return $this->pagamento->remover();
    }
    
    /**
     * Pesquisar os dados das formas de pagamento no Banco de Dados.
     * 
     * @access public
     * @return array[] Retorna uma lista de pagamentos de pendências e suas informações.
     */
    public function obterTodos(){
        return $this->pagamento->obter();
    }
    
    /**
     * Retorna lista de informações sobre a forma de pagamento desejada.
     * 
     * @param int $id Código da forma de pagamento desejada.
     * @return array[] Retorna o pagamento de pendências e suas informações.
     */
    public function obterUnidade($id){
        $this->pagamento->setId($id);
        
        return $this->pagamento->obter();
    }
}