<?php
include_once '../cls/sessao.class.php';

/*
 * @author Alessandro Marv�o <alessandromarvao@gmail.com>
 * @version 0.1
 * @copyright (c) 2015, Alessandro Marv�o
 */

$sessao = new Sessao();

if(!$sessao->situacaoOK()){
    header("location: ../php/logoff.php");
}

if(strcmp($sessao->getFuncao(), 'administrador')!==0){
    header("location: ../php/redirecionar.php");
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistema de Controle de Estoque e Vendas</title>
    
    <script src="../js/ajax.js"></script>
    <script src="js/usuario.js"></script>
    <script src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.maskedinput.js"/></script>
    <script>
        $(document).ready(function(){
            $(".cel").mask("(99)99999-9999");
            $("#tel").mask("(99)9999-9999");
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
<body>
    <div class="container content bg_herdado">
        <div class="row">
            <div id="div"></div>
            <div class="form-group col-md-6">
                <h2>Cadastro ou alteração dos dados do funcionário</h2>
                <br />
                <form>
                    <label>Escolha o login do funcionário</label>
                    <input type="text" class="form-control" id="login" placeholder="Digite aqui o login" autofocus required onblur="teste('obter', 'login')"/>
                    <br />
                    <label>Nome</label>
                    <input type="text" class="form-control" id="nome" placeholder="Digite aqui o nome completo do funcionário" required />
                    <br />
                    <label>CPF</label>
                    <input type="text" class="form-control" id="cpf" placeholder="Digite aqui o CPF" required />
                    <br />
                    <label>Função</label>
                    <select name="txtFuncao" id="funcao" class="form-control">
                        <option value="administrador" >Administrador do Sistema</option>
                        <option value="vendedor(a)" selected >Vendedor(a)</option>
                    </select>
                    <br />
                    <label>E-mail (Opcional)</label>
                    <input type="text" class="form-control" id="email" placeholder="Digite aqui o email do funcionário" />
                    <br />
                    <label>Data de Nascimento (Opcional)</label>
                    <input type="text" class="form-control" id="data_nascimento" placeholder="Digite aqui a data de nascimento do funcionário" required />
                    <br />
                    <label>Telefone (Opcional)</label>
                    <input type="text" class="form-control" id="tel" placeholder="Digite aqui o telefone fixo" />
                    <br />
                    <label>Celular (Opcional)</label>
                    <input type="text" class="form-control cel" id="cel1" placeholder="Digite aqui o telefone celular" />
                    <br/>
                    <label>Celular (Opcional)</label>
                    <input type="text" class="form-control cel" id="cel2" placeholder="Digite aqui o telefone celular" />
                    <br/>
                    <div class="row">
                        <div class='col-md-4 col-sm-3 spacing'>
                            <button type='button' class="btn btn-lg btn-block btn-success" title="Confirma o cadastro. Você será encaminhado à página de confirmação" onclick="salvar()">
                                <span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> Cadastrar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-3 spacing'>
                            <button type="reset" class="btn btn-lg btn-block btn-default" title="Limpa todos os campos preenchidos." >
                                <span class="glyphicon glyphicon-erase"></span> Limpar
                            </button>
                        </div>
                        <div class='col-md-4 col-sm-3 spacing'>
                            <a href="index.php" class="btn btn-lg btn-block btn-warning" title="Retornar à página principal">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 col-md-offset-2 hidden-sm hidden-xs">
                <img src="../img/img_24_1080x1920.jpg" class="img_lateral" alt="Espaço Conforto" />
            </div>
        </div>
    </div>
</body>
</html>