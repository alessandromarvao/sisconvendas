<?php
include_once '../cls/sessao.class.php';

/*
 * @author Alessandro Marvão <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marvão
 */

//$sessao = new Sessao();
//
//if(!$sessao->situacaoOK()){
//    header("location: ../php/logoff.php");
//}
//
//if(strcmp($sessao->getFuncao(), 'administrador')!==0){
//    header("location: ../php/redirecionar.php");
//}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="Windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/cadastrar_compra_moveis.js"></script>
    
    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="../css/signin.css">
</head>
<body class="bg_herdado">
    <div class="container content">
        <div class="row">
            <div class="form-group col-md-8 col-lg-6">
                <h2>Cadastro de Móvel</h2>
                <br />
                <h4>Adicionar móveis a partir de arquivo XML</h4>
                <div class="form-inline">
                    <input type="file" id="file" class="form-control" />
                    <button type="button" class="btn btn-success" onclick="salvar()" >
                        <span class="glyphicon glyphicon-download-alt"></span> Enviar</button>
                </div>
                <div id="loading"></div>
                <br/>
                <form role="form" action="../php/cadastrar_movel.php" method="POST" enctype='multipart/form-data' id='form1'>
                    <label>Adicione uma foto (opcional)</label>
                    <input type='file' name='imgMovel' class="form-control" value='Cadastrar foto' >
                    <br class="visible-md visible-lg" />
                    <label>Fornecedor</label>
                    <select name="txtFabricante" class="form-control">
                        <?php
                        include_once '../cls/fabricanteDAO.class.php';
                        $fabricante = new FabricanteDAO();
                        $resultado = $fabricante->obter();
                        foreach ($resultado as $linha){
                            echo "<option value='" . $linha['id_fabricante'] . "'>" . $linha['empresa'] . "</option>\n";
                        }
                        ?>
                    </select>
                    <br class="visible-md visible-lg" />
                    <label>Tipo</label>
                    <select name="txtTipo" class="form-control" required >
                        <option value='ABAJUR'>ABAJUR</option>
                        <option value='ALMOFADA'>ALMOFADA</option>
                        <option value='APARADOR'>APARADOR</option>
                        <option value='ARMARIO/AÇO'>ARMARIO /AÇO</option>
                        <option value='ARMARIO/COZINHA'>ARMARIO /COZINHA</option>
                        <option value='ARMARIO/ESCRITÓRIO'>ARMARIO /ESCRITÓRIO</option>
                        <option value='BALCÃO/AÇO'>BALCÃO /AÇO </option>
                        <option value='BALCÃO/COZINHA'>BALCÃO /COZINHA</option>
                        <option value='BALCÃO/ESCRITÓRIO'>BALCÃO /ESCRITÓRIO</option>
                        <option value='BANCO'>BANCO</option>
                        <option value='BANDEIJA'>BANDEIJA</option>
                        <option value='BANHEIRA'>BANHEIRA</option>
                        <option value='BANQUETA'>BANQUETA</option>
                        <option value='BAR'>BAR</option>
                        <option value='BASE AVULSA'>BASE AVULSA </option>
                        <option value='BASE CENTRO'>BASE CENTRO</option>
                        <option value='BASE CONSOLE'>BASE CONSOLE</option>
                        <option value='BASE JANTAR'>BASE JANTAR</option>
                        <option value='BASE LATERAL'>BASE LATERAL</option>
                        <option value='BASE LATERAL'>BASE LATERAL</option>
                        <option value='BAUZINHO'>BAUZINHO</option>
                        <option value='BELICHE'>BELICHE</option>
                        <option value='BERÇO'>BERÇO</option>
                        <option value='BERÇO AMERICANO'>BERÇO AMERICANO</option>
                        <option value='BICAMA'>BICAMA</option>
                        <option value='BUFFET /BALCÃO'>BUFFET /BALCÃO</option>
                        <option value='CABECEIRA'>CABECEIRA</option>
                        <option value='CABIDEIRO'>CABIDEIRO</option>
                        <option value='CADEIRA'>CADEIRA</option>
                        <option value='CADEIRA APOIO'>CADEIRA APOIO </option>
                        <option value='CADEIRA AVULSA'>CADEIRA AVULSA</option>
                        <option value='CADEIRA ESCRITÓRIO'>CADEIRA ESCRITÓRIO</option>
                        <option value='CADEIRA JANTAR'>CADEIRA JANTAR</option>
                        <option value='CADEIRA/CARRO'>CADEIRA/CARRO</option>
                        <option value='CAMA AUXILIAR'>CAMA AUXILIAR</option>
                        <option value='CAMA BABÁ'>CAMA BABÁ</option>
                        <option value='CAMA CAMPANHA'>CAMA CAMPANHA</option>
                        <option value='CAMA INFANTIL'>CAMA INFANTIL</option>
                        <option value='CAMA SOLTEIRO'>CAMA SOLTEIRO</option>
                        <option value='CAMA-BOX'>CAMA-BOX </option>
                        <option value='CANTINHO TRIBO'>CANTINHO TRIBO</option>
                        <option value='CARRINHO'>CARRINHO</option>
                        <option value='CERCADO'>CERCADO</option>
                        <option value='COLCHÃO'>COLCHÃO </option>
                        <option value='COMODA'>COMODA</option>
                        <option value='COMODA INFANTIL'>COMODA INFANTIL</option>
                        <option value='CONEXÃO P/ ESCRITÓRIO'>CONEXÃO P/ ESCRITÓRIO </option>
                        <option value='CONJUNTO TERRAÇO'>CONJUNTO TERRAÇO</option>
                        <option value='CONSOLE'>CONSOLE</option>
                        <option value='COOK-TOP'>COOK-TOP</option>
                        <option value='CORTINA VOAL'>CORTINA VOAL</option>
                        <option value='COZINHA'>COZINHA</option>
                        <option value='CRIADO MUDO'>CRIADO MUDO</option>
                        <option value='CRISTALEIRA'>CRISTALEIRA</option>
                        <option value='DEPURADOR'>DEPURADOR</option>
                        <option value='ENCOSTO TV'>ENCOSTO TV</option>
                        <option value='ENFEITE DE PORTA'>ENFEITE DE PORTA</option>
                        <option value='ENFEITE DE TETO'>ENFEITE DE TETO</option>
                        <option value='ESTANTE /ESCRITÓRIO'>ESTANTE /ESCRITÓRIO</option>
                        <option value='ESTANTE /HOME'>ESTANTE /HOME</option>
                        <option value='ESTEIRA P/ SOFÁ'>ESTEIRA P/ SOFÁ </option>
                        <option value='ESTOFADO'>ESTOFADO</option>
                        <option value='FARMACINHA'>FARMACINHA</option>
                        <option value='FORNO'>FORNO</option>
                        <option value='GAVETEIRO'>GAVETEIRO</option>
                        <option value='HOME'>HOME</option>
                        <option value='JOGO DE POTE'>JOGO DE POTE</option>
                        <option value='KIT /COZINHA'>KIT /COZINHA</option>
                        <option value='KIT DE BERÇO'>KIT DE BERÇO</option>
                        <option value='LUMINÁRIA'>LUMINÁRIA</option>
                        <option value='MESA /ESCRITÓRIO'>MESA /ESCRITÓRIO</option>
                        <option value='MESA APOIO'>MESA APOIO</option>
                        <option value='MESA APROXIMAÇÃO'>MESA APROXIMAÇÃO</option>
                        <option value='MESA CENTRO'>MESA CENTRO</option>
                        <option value='MESA JANTAR'>MESA JANTAR </option>
                        <option value='MESA LATERAL'>MESA LATERAL</option>
                        <option value='MESA P/COMPUTADOR'>MESA P/COMPUTADOR</option>
                        <option value='MESA/ESCRITÓRIO'>MESA/ESCRITÓRIO</option>
                        <option value='MODULO BANCADA'>MODULO BANCADA</option>
                        <option value='MODULO PAINEL'>MODULO PAINEL</option>
                        <option value='MODULO TORRE'>MODULO TORRE</option>
                        <option value='MOLDURA'>MOLDURA</option>
                        <option value='MULTIUSO'>MULTIUSO</option>
                        <option value='NICHO RETO'>NICHO RETO</option>
                        <option value='PAINEL/CABECEIRA'>PAINEL/CABECEIRA</option>
                        <option value='PAINEL/TOALHEIRO'>PAINEL/TOALHEIRO</option>
                        <option value='PAINEL TV'>PAINEL TV</option>
                        <option value='PANELEIRO'>PANELEIRO</option>
                        <option value='POLTRONA/PAPAI'>POLTRONA/PAPAI</option>
                        <option value='POLTRONA AMAMENTAÇÃO'>POLTRONA AMAMENTAÇÃO</option>
                        <option value='POLTRONA APOIO '>POLTRONA APOIO </option>
                        <option value='PRATELEIRA'>PRATELEIRA</option>
                        <option value='PRATO GIRATÓRIO'>PRATO GIRATÓRIO</option>
                        <option value='PUFF'>PUFF</option>
                        <option value='RACK'>RACK</option>
                        <option value='RACK/MULTIUSO'>RACK/MULTIUSO</option>
                        <option value='RACK BALCÃO'>RACK BALCÃO</option>
                        <option value='RACK BANCADA'>RACK BANCADA</option>
                        <option value='RECAMIER'>RECAMIER</option>
                        <option value='REVISTEIRO'>REVISTEIRO</option>
                        <option value='ROLO'>ROLO</option>
                        <option value='ROUPEIRO'>ROUPEIRO</option>
                        <option value='ROUPEIRO INFANTIL'>ROUPEIRO INFANTIL</option>
                        <option value='SALA JANTAR'>SALA JANTAR</option>
                        <option value='SOFÁ-CAMA'>SOFÁ-CAMA</option>
                        <option value='TABUA PASSAR'>TABUA PASSAR</option>
                        <option value='TAMPO CENTRO'>TAMPO CENTRO</option>
                        <option value='TAMPO CONSOLE'>TAMPO CONSOLE</option>
                        <option value='TAMPO JANTAR'>TAMPO JANTAR</option>
                        <option value='TAMPO LATERAL'>TAMPO LATERAL</option>
                        <option value='TAPETE'>TAPETE</option>
                        <option value='TORRE'>TORRE</option>
                        <option value='TOUCADOR'>TOUCADOR</option>
                        <option value='TRAVESSEIRO'>TRAVESSEIRO</option>
                        <option value='TRILICHE'>TRILICHE</option>
                        <option value='TROCADOR'>TROCADOR</option>
                        <option value='TROCADOR'>TROCADOR</option>
                        <option value='TV LCD'>TV LCD</option>

                    </select>
                    <br class="visible-md visible-lg" />
                    <label>Modelo</label>
                    <input type="text" name="txtModelo" class="form-control" placeholder="Digite aqui o modelo do móvel" />
                    <br class="visible-md visible-lg" />
                    <label>Preço Final</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input type="text" name="txtValor" class="form-control" placeholder="Digite aqui o valor que o móvel será vendido ao cliente" />
                    </div>
                    <br class="visible-md visible-lg" />
                    <br/>
                    <div class="row">
                        <div class='col-md-4 col-sm-4 spacing'>
                            <button type="submit" class="btn btn-lg btn-block btn-success" form="form1" value="Submit" title="Confirma o cadastro. Você será encaminhado à página de confirmação">
                                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Cadastrar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-4 spacing'>
                            <button type="reset" class="btn btn-lg btn-block btn-default " title="Limpa todos os campos preenchidos." >
                                <span class="glyphicon glyphicon-erase"></span> Limpar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-4 spacing'>
                            <a href="index.php" class="btn btn-lg btn-block btn-warning" title="Cancela o cadastro e volta à pagina ininical">
                                <span class="glyphicon glyphicon-remove"></span> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-lg-4 col-lg-offset-2 hidden-xs hidden-sm">
                <img src="../img/img_5_1080x1920.jpg" class="img_lateral" />
            </div>
        </div>
    </div>
</body>
</html>