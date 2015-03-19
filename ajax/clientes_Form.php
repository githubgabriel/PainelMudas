<?php ob_start();

include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\clientes;
//use base\upload\upload;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();


$_PAGE_LIST = "clientes.php";
$_PAGE_FORM = "clientes_Form.php";


/* INSERT ou UPDATE */
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST,"telefone",FILTER_SANITIZE_STRING);

    if($nome) {

        $obj = new clientes();

        $obj->setId($id);
        $obj->setNomeCompleto($nome);
        $obj->setEmail($email);
        $obj->setTelefone($telefone);

        try {
            $p = $conexao->prepare($obj->save());
            $p->execute();
        } catch (Exception $e) {
            echo $e->getMessage(); die();
        }

        redirecionarAjax("ajax/".$_PAGE_LIST);

        $formStatus = "sucesso";
    } else {
        $formStatus = "erro";
    }
}


if(isset($_REQUEST["id"])) {

    $id = $_REQUEST["id"];

    if($id > 0) {

        $obj = new clientes();

        try {

            $p = $conexao->prepare($obj->getRowById($id));
            $p->execute();
            $colunas = $p->fetchObject();

        } catch (Exception $e) {
            echo $e->getMessage(); die();
        }

    }

}

if($_GET["excluir"] == "1") {

    $id = $_REQUEST["id"];

    $obj = new clientes();

    try {
        $p = $conexao->prepare($obj->getDelete($id));
        $p->execute();
        $colunas = $p->fetchObject();
    } catch (Exception $e) {
        echo $e->getMessage(); die();
    }
    redirecionarAjax("ajax/".$_PAGE_LIST);
}

?>
<? if($formStatus == "sucesso") { ?>
    <script>
        alert('Registrado com sucesso!');
    </script>
<?  } ?>
<? if($formStatus == "erro") { ?>
    <script> alert('Erro ao registrar!'); </script>
<? } ?>

<? if(!$colunas->id) { ?>
    <h2 style="color:green;"> Novo Registro </h2>
<? } else { ?>
    <h2 style="color:green;"> Atualizar Registro </h2>
<? } ?>

<small>
    <? if($colunas->data_criacao) { echo parseDataHoraBR($colunas->data_criacao);
        ?> <a href="#" onclick="return deletar(<?=$colunas->id?>);"> Excluir </a><? } ?>
</small>

<form action="#" onsubmit="return enviaForm()" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$colunas->id?>">



    <div id="form" class="wid25">
        <label> Nome Completo </label>
        <br>
        <input type="text" name="nome" value="<?=$colunas->nome_completo?>" />
    </div>




    <div id="form" class="wid50">

        <label> E-mail </label>
        <br>
        <input type="text" name="email" value="<?=$colunas->email?>" />

    </div>



    <div class="clear"> </div>


    <div id="form">

        <label> Telefone </label>
        <br>
        <input type="text" name="telefone" value="<?=$colunas->telefone?>" />

    </div>


    <br>
    <div id="form">
        <input type="submit" value="Registrar" />
    </div>

</form>

<script>
    function enviaForm() {

        fileData = new FormData($("form")[0]);

        ajaxLoadPage(null, "post", "ajax/<?=$_PAGE_FORM?>", fileData);

        return false;
    }

    function deletar(id) {
        ajaxLoadPage(null, "get", "ajax/<?=$_PAGE_FORM?>", "id="+id+"&excluir=1");
    }
</script>