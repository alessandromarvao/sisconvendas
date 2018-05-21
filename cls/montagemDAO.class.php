<?php
include_once 'montagem.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada �s opera��es de montagem do m�vel no Banco de Dados.
 *
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 * @access public
 */
class MontagemDAO {
    /**
     * Vari�vel que recebe o objeto da classe entrega.
     * 
     * @access private
     * @var Object
     */
    private $montagem;
    
    function __construct() {
        $this->montagem = new Montagem();
    }
    
    /**
     * Armazena as informa��es da entrega no Banco de Dados.
     * 
     * @access public
     * @param int $vendaDoMovel C�digo da venda do m�vel.
     * @param date $data Data da montagem do m�vel.
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
     * @param int $vendaDoMovel C�digo da venda do m�vel.
     * @param date $data Data da montagem do m�vel.
     * @return boolean Retorna TRUE se a altera��o for realizada com sucesso e 
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
     * @param int $idVendaDoMovel C�digo da venda do m�vel.
     * @return array Retorna todas as montagens registradas no Sistema.
     */
    public function obterPorMovelVendido($idVendaDoMovel){
        $this->montagem->setVendaMovel($idVendaDoMovel);
        
        return $this->montagem->obter();
    }
    
    
    /**
     * Retorna todas as montagens registradas num per�do de tempo determinado.
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
     * Verifica se existe ou n�o montagem para a venda do m�vel selecionado.
     * 
     * @access public
     * @param int $idVendaDoMovel C�digo da venda do m�vel.
     * @return boolean return TRUE se tem montagem do m�vel selecionado e FALSE se n�o houver.
     */
    public function temMontagem($idVendaDoMovel){
        $this->montagem->setVendaMovel($idVendaDoMovel);
        
        return $this->montagem->temMontagem();
    }
}
