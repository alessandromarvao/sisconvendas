<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
include_once '../cls/movel.class.php';
include_once '../cls/upload.class.php';

/**                                   **
 *                                    **
 * ESPAÇO RESERVADO PARA A SESSÃO     **
 *                                    **
 *                                    */

// Garante que o navegador do usuário não realize cache
header('Expires: Wed 24 Dec 1980 00:30 GMT'); // Expira em uma data passada, para limpar o cache 
header('Last-Modified: ' . gmdate('D, d m y H:i:s') . 'GMT'); // Confere a data da última modificação da página
header('Cache-Control: no-cache, must-revalidade'); // Não vai ser armazenada em cache
header('Pragma: no-cache'); // Não vai ser armazenada em cache

?>
<html>
    <head>
        <meta charset="Windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>ESPAÇO CONFORTO - Cadastrar Usuário</title>
        
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

        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../css/signin.css" />
    </head>
    <body class="bg_herdado">
        <br/>
        <br/>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>
                        <?php
                        
                        $end_img = "";
                        $img = "";
                        $fab = "";
                        $tipo = "";
                        $model = "";
                        $marca = "";
                        $lucro = "";
                        $estoque = 0;
                        $id = 0;
                        
                        if(!empty($_FILES['imgMovel']['tmp_name'])){
                            echo "chegou aqui. ";
                            $img = $_FILES['imgMovel'];
                            $upload = new Upload($img, 600, 800);
                            $end_img = $upload->salvar();
                        }
                        if(isset($_POST['txtFabricante'])){
                            $fab = $_POST['txtFabricante'];
                        }
                        if(isset($_POST['txtTipo'])){
                            $tipo = $_POST['txtTipo'];
                        }
                        if(isset($_POST['txtModelo'])){
                            $model = $_POST['txtModelo'];
                        }
                        if(isset($_POST['txtValor'])){
                            $aux = explode(",", $_POST['txtValor']);
                            $valor = (double) implode(".", $aux);
                            $preco = number_format($valor, 2, ".", "");
                        }
                        if(isset($_POST['txtId'])){
                            $id = $_POST['txtId'];
                        }
                        if(isset($_POST['txtEstoque'])){
                            $estoque = $_POST['txtEstoque'];
                        }
                        
                        $movel = new Movel();
                        
                        if($movel->salvar($id, $fab, $tipo, $model, $preco, $estoque, $end_img)){
                            echo "Cadastro realizado com sucesso.";
                        } else {
                            echo "Não foi possível cadastrar este móvel porque ele já está cadastrado no Sistema.";
                        }
                        
                        ?>
                    </h2>
                </div>
            </div>
            <br/>
            <div class="row">                
            </div>
            <br/>
            <br/>
            <div class="row">
                <div class="col-md-2 col-sm-3">
                    <a href="../admin/index.php" class="btn btn-lg btn-success btn-block" title="Retornar à página inicial." >Voltar</a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="../admin/cadastrar_movel.php" class="btn btn-lg btn-default btn-block" title="Retornar à página de cadastro de móvel">Novo Cadastro</a>
                </div>
                <div class="col-md-2 col-sm-3">
                    <a href="logoff.php" class="btn btn-lg btn-warning btn-block" title="Encerrar a sessão e retornar à página de login." >Sair</a>
                </div>
            </div>
            <br/>
            <br/>
        </div>
    </body>
    
</html>
