<?php

/**
 * Classe que realiza o upload de imagens e as redimensiona.
 *
 * @author Marco Antoni <marquinho9.10@gmail.com>
 * @link http://www.devmedia.com.br/classe-para-upload-de-imagens-em-php-com-redimensionamento/28573 P�gina do tutorial.
 * 
 */
class Upload {
    private $arquivo;
    private $altura;
    private $largura;
    private $pasta;
    
    function __construct($arquivo, $altura, $largura) {
        $this->arquivo = $arquivo;
        $this->altura = $altura;
        $this->largura = $largura;
        $this->pasta = "../fotos/";
    }
    
    private function getExtensao(){
        //retorna a extens�o da imagem
        return $extensao = strtolower(end(explode('.', $this->arquivo['name'])));
    }
    
    private function ehImagem($extensao){
        $extensoes = array ('gif', 'jpeg', 'jpg', 'png');  //extens�es permitidas
        if(in_array($extensao, $extensoes))
                return true;
    }
    
    //largura, altura, tipo, localiza��o da imagem original
    private function redimensionar($imgLarg, $imgAlt, $tipo, $img_localizacao) {
        //descobrir novo tamanho sem perder a propor��o
        if($imgLarg > $imgAlt){
            $novaLarg = $this->largura;
            $novaAlt = round(($novaLarg / $imgLarg) * $imgAlt);
        } elseif($imgAlt > $imgLarg){
            $novaAlt = $this->altura;
            $novaLarg = round(($novaAlt / $imgAlt) * $imgLarg);
        } else {//altura == largura
            $novaAlt = $novaLarg = max($this->largura, $this->altura);
        }
        
        //Redimensionar Imagem:
        //cria uma nova imagem com o novo tamanho
        $novaImagem = imagecreatetruecolor($novaLarg, $novaAlt);
        
        switch($tipo){
            case 1: //gif
                $origem = imagecreatefromgif($img_localizacao);
                imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0, 
                        $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagegif($novaImagem, $img_localizacao);
                break;
            case 2: //jpeg
                $origem = imagecreatefromjpeg($img_localizacao);
                imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0, 
                        $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagejpeg($novaImagem, $img_localizacao);
                break;
            case 3: //png
                $origem = imagecreatefrompng($img_localizacao);
                imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0, 
                        $novaLarg, $novaAlt, $imgLarg, $imgAlt);
                imagepng($novaImagem, $img_localizacao);
                break;
        }
        
        //destr�i as imagens criadas
        imagedestroy($novaImagem);
        imagedestroy($origem);
    }
    
    public function salvar(){
        $extensao = $this->getExtensao();
        
        //gera um nome �nico para a imagem em fun��o do tempo
        $novo_nome = time() . '.' . $extensao;
        
        //localiza��o do arquivo
        $destino = $this->pasta . $novo_nome;
        
        //move o arquivo
        if( !move_uploaded_file($this->arquivo['tmp_name'], $destino)){
            if($this->arquivo['error'] == 1){
                return "Tamanho excede o permitido";
            } else {
                return "Erro " . $this->arquivo['error'];
            }
        }
        
        if($this->ehImagem($extensao)){
            //pega a largura, altura, tipo e atributo da imagem
            list($largura, $altura, $tipo, $atributo) = getimagesize($destino);
            
            //testa se � preciso redimensionar a imagem
            if(($largura > $this->largura) || ($altura > $this->altura))
                $this->redimensionar ($largura, $altura, $tipo, $destino);
        }
        
        return $destino;
    }
}
