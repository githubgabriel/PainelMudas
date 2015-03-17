<?php include "BASEV2/basev2.php"; getBaseV2("php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Gerenciar Mudas de Plantas</title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/site.css">

    <?php getBaseV2("css"); ?>

    <?php getBaseV2("javascript"); ?>

    <script src="js/site.js"> </script>


</head>
<body>

<div style="font-size:22px; color:white; text-align: center; margin-top:40px;">
        GERENCIADOR DE MUDAS
    </div>

    <div id="conteudo-login" class="bg_1" style="margin-top:3%;">
        <div id="conteudo">
            <form action="actions.php" onsubmit="return subimita()" method="post">
                <input type="hidden" name="a" value="login_session"/>
                <div id="form">
                    <label> <b>Login</b> </label>
                    <br>
                    <input type="text" name="login" />
                </div>
                <div id="form">
                    <label><b>Senha</b> </label>
                    <br>
                    <input type="text" name="senha" />
                </div>
                <div id="form">
                   <input type="submit" value="Logar" />
                </div>
            </form>
        </div>
    </div>

<script>
    function subimita() {
        return true;
    }
</script>

</body>
</html>