<?php
include_once 'conexao.class.php';

// garante que o navegador do usuario nao realize cache
header('Expires: Wed, 23 Dec 1980 00:30:00 GMT');
header('Last-Modified: ' . gmdate('D, d M y H:i:s') . '  GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

/**
 * Classe relacionada às operações dos móveis no Banco de Dados.
 * Armazena o código do móvel (gerado automaticamente), código do fabricante,
 * tipo de móvel (cadeira, sofá, cama etc), modelo, porcentagem de lucro a ser
 * adicionado no valor de revenda (não será exibido a ninguém, apenas irá gerar 
 * o valor final do produto) e o endereço em que se encontra a imagem relacionada
 * ao produto.
 *
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 * @access public
 */
class Movel {
    /**
     * Variável que inicia a conexão com o BD e realiza as operações no mesmo.
     *
     * @var Object
     * @access private
     */
    private $conexao;
    
    /**
     * Variável que recebe o código do móvel no Sistema.
     * @access private
     * @var int
     */
    private $id;
    
    /**
     * Variável que recebe o código da empresa fabricante do móvel no Sistema.
     * @access private
     * @var int
     */
    private $fabricante;
    
    /**
     * Variável que recebe o tipo de móvel no Sistema.
     * @access private
     * @var string 
     */
    private $tipo;
    
    /**
     * Variável que recebe o modelo do móvel no Sistema.
     * @access private
     * @var string 
     */
    private $modelo;
    
    /**
     * Variável que recebe a porcentagem de lucro do móvel no Sistema.
     * @access private
     * @var double 
     */
    private $valorVenda;
    
    /**
     * Variável que recebe o endereço da imagem do móvel no Sistema.
     * @access private
     * @var string
     */
    private $movelImg;
    
    /**
     * Variável que recebe a quantidade do móvel no estoque no Sistema.
     * @access private
     * @var string
     */
    private $estoque;
    
    /**
     * Inicia as operações dos móveis no Banco de Dados.
     * 
     * @return void
     */
    function __construct(){ 
        $this->conexao = Conexao::conectar();
        
        //Caso o construtor do objeto iniciar com parâmetros, encaminha ao construtor desejado
        $a = func_get_args(); 
        $i = func_num_args(); 
        if (method_exists($this,$f='__construct'.$i)) { 
            call_user_func_array(array($this,$f),$a); 
        } 
    }
    
    /**
     * Inicia o objeto Móvel com o seu código selecionado.
     * 
     * @param int $id Código do móvel desejado.
     */
    function __construct1($id){
        $this->id = (int) $id;
    }
    
    /**
     * Inicia o objeto Movel com o seu código e a quantidade no estoque desejada.
     * 
     * @param int $id Código do Móvel desejado.
     * @param double $valor
     * @param int $estoque
     */
    function __construct2($id, $estoque) {
        $this->id = (int) $id;
        $this->estoque = (int) $estoque;
    }
    
    /**
     * Armazena o valor desejado na variável $modelo.
     * 
     * @param string $valor
     */
    public function setModelo($valor) {
        $this->modelo = $valor;
    }
    
    /**
     * Confere se a variável desejada existe e é maior que zero.
     * 
     * @param int $var
     * @return boolean Retorna TRUE se as condições forem atendidas e FALSE se não.
     */
    private function isVarOk($var){
        if(isset($this->$var) && $this->$var>0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Armazena as informações do móvel no Banco de Dados ou altera os mesmos se o código do móvel for especificado.
     * 
     * @access public
     * @param int $id Código do Móvel no Banco de Dados.
     * @param int $fabricante Código do fabricante do móvel no Banco de Dados.
     * @param string $tipo Tipo do móvel selecionado.
     * @param string $modelo Modelo do móvel selecionado.
     * @param double $valor Valor da venda do móvel.
     * @param string $movelImg Link da imagem do móvel.
     * @return boolean Retorna TRUE se o cadastro for realizado com sucesso e FALSE se ocorrer algum erro.
     */
    public function salvar($id, $fabricante, $tipo, $modelo, $valor, $estoque, $movelImg){
        $this->id = $id;
        $this->fabricante = $fabricante;
        $this->tipo = $tipo;
        $this->modelo = $modelo;
        $this->valorVenda = $valor;
        $this->estoque = $estoque;
        $this->movelImg = $movelImg;
        
        if($this->isVarOk("id")){
            $query = "UPDATE movel SET tipo=?, modelo=?, valor_venda=?, movel_img=?, estoque=?, id_fabricante_FK=? WHERE id_movel=?";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->tipo);
            $stmt->bindParam(2, $this->modelo);
            $stmt->bindParam(3, $this->valorVenda);
            $stmt->bindParam(4, $this->movelImg);
            $stmt->bindParam(5, $this->estoque);
            $stmt->bindParam(6, $this->fabricante);
            $stmt->bindParam(7, $this->id);
        } else {
            $query = "INSERT INTO movel(id_fabricante_FK, tipo, modelo, valor_venda, movel_img, estoque) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->fabricante);
            $stmt->bindParam(2, $this->tipo);
            $stmt->bindParam(3, $this->modelo);
            $stmt->bindParam(4, $this->valorVenda);
            $stmt->bindParam(5, $this->movelImg);
            $stmt->bindParam(6, $this->estoque);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Adiciona a quantidade desejada do móvel selecionado no estoque
     * 
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function adicionarEstoque($id, $qtde){
        $this->id = (int) $id;
        $this->estoque = (int) $qtde;
        $stmt = $this->conexao->prepare("UPDATE movel SET estoque=estoque+? WHERE id_movel=?");
        $stmt->bindParam(1, $this->estoque);
        $stmt->bindParam(2, $this->id);

        return $stmt->execute();
    }
    
    /**
     * Remove a quantidade desejada do móvel selecionado no estoque
     * 
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e FALSE se ocorrer algum erro.
     */
    public function removerEstoque($id, $estoque){
        $this->id = $id;
        $this->estoque = $estoque;
        
        $stmt = $this->conexao->prepare("UPDATE movel SET estoque=estoque-? WHERE id_movel=?");
        $stmt->bindParam(1, $this->estoque);
        $stmt->bindParam(2, $this->id);

        return $stmt->execute();
    }
    
    /**
     * Deleta do Banco de Dados as informações do móvel selecionado.
     * Não poderá ser deletado do Banco de Dados o móvel que já realizou algum
     * cadastro no Sistema.
     * 
     * @access public
     * @return boolean Retorna TRUE se a operação for realizada com sucesso e 
     * FALSE se ocorrer algum erro.
     */
    public function remover(){
        if(isset($this->id)){
            $stmt = $this->conexao->prepare("DELETE FROM movel WHERE id_movel=?");
            $stmt->bindParam(1, $this->id);
            
            return $stmt->execute();
        } else {
            return FALSE;
        }
    }
    
    /**
     * Pesquisar os dados do(s) móvel(eis) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informações do(s) móvel(eis)
     */
    public function obter(){
        $query = "SELECT a.id_movel, b.id_fabricante, b.empresa, a.tipo, a.modelo,"
                 . " a.valor_venda, a.estoque, a.movel_img FROM movel a, fabricante b"
                . " WHERE a.id_fabricante_FK=b.id_fabricante";
        if(isset($this->id)){ //Por código de móvel
            $query .= " AND id_movel=? ORDER BY a.modelo ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif(isset($this->fabricante)){ //Por fabricante
            $query .= " AND id_fabricante_FK=? ORDER BY a.modelo ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->fabricante);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif(isset($this->tipo)){ //Por tipo
            $query .= " AND tipo LIKE ? ORDER BY a.modelo ASC";
            $this->tipo = "%" . $this->tipo . "%";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->tipo);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif(isset($this->modelo)){ //Por modelo
            $query .= " AND modelo LIKE ? ORDER BY a.modelo ASC";
            $this->modelo = "%" . $this->modelo . "%";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->modelo);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else { //Retorna todos
            $query .= " ORDER BY a.modelo ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Pesquisar os dados do(s) móvel(eis) no Sistema.
     * 
     * @access public
     * @return array[] Retorna a lista contendo as informações do(s) móvel(eis)
     */
    public function obterEstoqueBaixo(){
        $query = "SELECT a.id_movel, b.id_fabricante, b.empresa, a.tipo, a.modelo,"
                 . " a.valor_venda, a.estoque, a.movel_img FROM movel a, fabricante b"
                . " WHERE a.id_fabricante_FK=b.id_fabricante AND a.estoque<2";
        if(isset($this->modelo)){ //Por modelo
            $query .= " AND modelo LIKE ? ORDER BY a.modelo ASC";
            $this->modelo = "%" . $this->modelo . "%";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(1, $this->modelo);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else { //Retorna todos
            $query .= " ORDER BY a.modelo ASC";
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    
    /**
     * Retorna todos os tipos de móveis cadastrados no Banco de Dados.
     * 
     * @return array
     */
    public function obterTipos(){
        $stmt = $this->conexao->prepare("SELECT distinct(tipo) FROM movel");
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retorna a quantidade do estoque do móvel desejado.
     * 
     * @param int $id Código do móvel desejado
     * @return int
     */
    public function obterQtdeEstoqueMovel($id){
        $this->id = $id;
        
        $stmt = $this->conexao->prepare("SELECT estoque FROM movel WHERE id_movel=?");
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC)['estoque'];
    }
}