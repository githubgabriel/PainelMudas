<?php ob_start();

    include "BASEV2/basev2.php"; getBaseV2("php");

    use base\ambiente_restrito\ambiente_restrito;

    $a = $_REQUEST["a"];
    if(!$a) { die("ERRO: 'A' VARIAVEL "); }

    if($a == "login_session") {

        $login = filter_input(INPUT_POST, "login",FILTER_SANITIZE_STRING);
        $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_STRING);

        $re = ambiente_restrito::validarLoginSenha($login,$senha);

        if($re) {

        } else {

           echo "<script> window.location.href= 'login.php'; </script>";

        }
        echo "ae";
    }



?>