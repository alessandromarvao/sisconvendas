<?php
include_once 'montagem.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações de montagem do móvel no Banco de Dados.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class MontagemDAO {
    /**
     * Variável que recebe o objeto da classe entrega.
     * 
     * @access private
     * @var Object
     */
    private $montagem;
    
    function __construct() {
        $this->montagem = new Montagem();
    }
    
    /**
     * Armazena as informações da entrega no Banco de Dados.
     * 
     * @access public
     * @param int $vendaDoMovel Código da venda do móvel.
     * @param date $data Data da montagem do móvel.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function salvar($vendaDoMovel, $data){
        $this->montagem->setVendaMovel($vendaDoMovel);
        $this->montagem->setData($data);
        
        return $this->montagem->salvar();
    }
    
    /**
     * 
     * @param int $vendaDoMovel Código da venda do móvel.
     * @param date $data Data da montagem do móvel.
     * @return boolean Retorna TRUE se a alteração for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function alterarData($vendaDoMovel, $data){
        $this->montagem->setVendaMovel($vendaDoMovel);
        $this->montagem->setData($data);
        
        return $this->montagem->alterar();
    }
    
    /**
     * Retorna todas as montagens registradas no Sistema.
     * 
     * @access public
     * @return array Retorna todas as montagens registradas no Sistema.
     */
    public function obterTodos(){
        return $this->montagem->obter();
    }
    
    /**
     * Retorna todas as montagens registradas no Sistema.
     * 
     * @access public
     * @param int $idVendaDoMovel Código da venda do móvel.
     * @return array Retorna todas as montagens registradas no Sistema.
     */
    public function obterPorMovelVendido($idVendaDoMovel){
        $this->montagem->setVendaMovel($idVendaDoMovel);
        
        return $this->montagem->obter();
    }
    
    
    /**
     * Retorna todas as montagens registradas num perído de tempo determinado.
     * 
     * @access public
     * @param date $data1 Data inicial.
     * @param date $data2 Data final.
     * @return array Retorna todas as montagens registradas no Sistema.
     */
    public function obterPorPeriodoDeData($data1, $data2){
        return $this->montagem->obterPorIntervaloDeDatas($data1, $data2);
    }
    
    /**
     * Verifica se existe ou não montagem para a venda do móvel selecionado.
     * 
     * @access public
     * @param int $idVendaDoMovel Código da venda do móvel.
     * @return boolean return TRUE se tem montagem do móvel selecionado e FALSE se não houver.
     */
    public function temMontagem($idVendaDoMovel){
        $this->montagem->setVendaMovel($idVendaDoMovel);
        
        return $this->montagem->temMontagem();
    }
}
