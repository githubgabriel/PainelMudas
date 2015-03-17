<?php include "BASEV2/basev2.php"; getBaseV2("php");
?>
<!doctype html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Document</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/site.css">

    <?php getBaseV2("css"); ?>

    <?php getBaseV2("javascript"); ?>

    <script src="js/site.js"> </script>


</head>
<body>


    <div id="menu-box" class="bg_1">
        <div id="sessao-usuario"> Gabriel A. Barbosa - <button onclick="return logout();"> Logout </button> </div>
        <ul>

            <li class="active" onclick="return ajaxLoadPage(this,'get','ajax/home.php')"> Home </li>

            <li onclick="return ajaxLoadPage(this,'get','ajax/estoque_mudas.php')"> Estoque de Mudas </li>

            <li onclick="return ajaxLoadPage(this,'get','ajax/especiesfamilias.php')"> Especies & Familias </li>

            <li onclick="return ajaxLoadPage(this,'get','ajax/vendas.php')"> Vendas </li>

            <li onclick="return ajaxLoadPage(this,'get','ajax/clientes.php')"> Clientes </li>

            <li onclick="return ajaxLoadPage(this,'get','ajax/relatorios.php')"> Relatorios </li>

        </ul>
        <div class="clear"> </div>
    </div>

    <div id="conteudo-box" class="bg_1">
        <div id="ajax_loader"> Carregando... </div>
        <div id="conteudo">

        </div>
    </div>


    <script>
        /* Chama pagina home apos iniciar aplicação... */
        ajaxLoadPage(null,'get','ajax/home.php');
    </script>

</body>
</html>