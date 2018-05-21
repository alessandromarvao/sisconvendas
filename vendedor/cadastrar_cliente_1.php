<?php
include_once '../cls/sessao.class.php';

$sessao = new Sessao();
//Confere se a autenticação foi validada.
if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'vendedor(a)')!==0){
    header("location: ../php/logoff.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="Windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas - ESPAÇO CONFORTO</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/cliente.js"></script>
    <script src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.maskedinput.js"/></script>
    <script>
        $(document).ready(function(){
            $(".cel").mask("(99)99999-9999");
            $("#tel").mask("(99)9999-9999");
            $("#cep").mask("99999-999");
            $("#cpf").mask("999.999.999-99");
            $("#data_nascimento").mask("99/99/9999");
        });
    </script>

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
<body class="bg_lft">
    <div class="container content">
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group col-md-10">
                    <h2>Cadastro de cliente</h2>
                    <br />
                    <form role="form" method="POST">
                        <label>CPF</label>
                        <input type="text" class="form-control" id="cpf" placeholder="Digite aqui o CPF" onblur="enviaDados('obter', 'cpf')" autofocus required />
                        <br />
                        <label>Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Digite aqui o nome completo do funcionário" required />
                        <br />
                        <label>E-mail (Opcional)</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite aqui o nome completo do funcionário" required />
                        <br />
                        <label>Data de Nascimento (Opcional)</label>
                        <input type="text" class="form-control" id="data_nascimento" placeholder="DD/MM/AAAA" required />
                        <br />
                        <label>Endereço</label>
                        <input type="text" class="form-control" id="end" placeholder="rua, casa ou apartamento, bloco ou quadra" required />
                        <br />
                        <label>Bairro</label>
                        <input type="text" class="form-control" id="bai" placeholder="Digite aqui o bairro que o cliente reside atualmente" required />
                        <br />
                        <label>Ponto de Referência</label>
                        <input type="text" class="form-control" id="ref" placeholder="Digite aqui um local como ponto de referência à residência do cliente" required />
                        <br />
                        <label>CEP (Opcional)</label>
                        <input type="text" class="form-control" id="cep" placeholder="Digite aqui o CEP do endereço do cliente" />
                        <br />
                        <label>Telefone(Opcional)</label>
                        <input type="text" class="form-control" id="tel" placeholder="Digite aqui o telefone fixo" />
                        <br />
                        <label>Celular(Opcional)</label>
                        <input type="text" class="form-control cel" id="cel1" placeholder="Digite aqui o telefone celular" />
                        <br />
                        <label>Celular(Opcional)</label>
                        <input type="text" class="form-control cel" id="cel2" placeholder="Digite aqui o telefone celular" />
                        <br/>
                        <div class="row">
                            <div class='col-md-4'>
                                <input type="button" class="btn btn-lg btn-block btn-success spacing" value="Cadastrar" onclick="enviaDados('salvar', 'cpf')" />
                            </div>
                            <div class='col-md-4'>
                                <input type="reset" class="btn btn-lg btn-block btn-default spacing" value="Limpar"/>
                            </div>
                            <div class='col-md-4'>
                                <a href="index.php" class="btn btn-lg btn-block btn-warning spacing" title="Cancela o cadastro e volta à pagina ininical">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4 hidden-xs">
                <img src="../img/img_23_1080x1920.jpg" class="img-responsive img_lateral"  />
            </div>
        </div>
    </div>
</body>
</html>
