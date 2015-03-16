<?php include "BASEV2/basev2.php"; getBaseV2("php"); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/site.css">

    <?php getBaseV2("css"); ?>

    <?php getBaseV2("javascript"); ?>



</head>
<body>

    <div id="menu-box" class="bg_1">
        <ul>
            <li onclick="return ajaxLoadPage(this,'get','ajax/estoque_mudas.php')"> Estoque Mudas </li>
            <li onclick="return ajaxLoadPage(this,'get','ajax/clientes.php')"> Clientes </li>
            <li onclick="return ajaxLoadPage(this,'get','ajax/financeiro.php')"> Financeiro </li>
        </ul>
        <div class="clear"> </div>
    </div>

    <div id="conteudo-box" class="bg_1">
        <div id="ajax_loader"> Carregando... </div>
        <div id="conteudo">
            Conteudo
        </div>
    </div>

</body>
</html>