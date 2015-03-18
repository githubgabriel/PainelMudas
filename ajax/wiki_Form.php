<?php ob_start();

include "../BASEV2/basev2.php"; getBaseV2("php",".");


use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\wikiMudas;
//use base\upload\upload;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();



$_PAGE_LIST = "wiki.php";
$_PAGE_FORM = "wiki_Form.php";


/* INSERT ou UPDATE */
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $titulo = filter_input(INPUT_POST,"titulo",FILTER_SANITIZE_STRING);
    $conteudo = filter_input(INPUT_POST,"conteudo", FILTER_SANITIZE_MAGIC_QUOTES);

    if($titulo) {

        $obj = new wikiMudas();

        $obj->setId($id);
        $obj->setIdEspecie($_POST["especie_id"]);
        $obj->setTitulo($titulo);
        $obj->setConteudo(htmlspecialchars($conteudo));

        try {

            $p = $conexao->prepare($obj->save());
            $p->execute();
        } catch (Exception $e) {
            echo $e->getMessage(); die();
        }

        redirecionarAjax("ajax/".$_PAGE_LIST."?id=".$_REQUEST["especie_id"]);

        $formStatus = "sucesso";
    } else {
        $formStatus = "erro";
    }
}


if(isset($_REQUEST["id"])) {

    $id = $_REQUEST["id"];

    if($id > 0) {

        $obj = new wikiMudas();

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

    $obj = new wikiMudas();

    try {
        $p = $conexao->prepare($obj->getDelete($id));
        $p->execute();
        $colunas = $p->fetchObject();
    } catch (Exception $e) {
        echo $e->getMessage(); die();
    }
    redirecionarAjax("ajax/".$_PAGE_LIST."?id=".$_REQUEST["especie_id"]);

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
    <input type="hidden" name="especie_id" value="<?=$_GET["especie_id"]?>">

    <div id="form">
        <label> Titulo </label>
        <br>
        <input type="text" style='width: 99%;' name="titulo" value="<?=$colunas->titulo?>" />
    </div>


    <script>
        $("textarea").jqte();
    </script>

    <div id="form" style="position:relative;">

        <label> Conteudo </label>
        <br>
        <textarea class="jqte" type="text" style='position:relative;width:100%;min-height:250px;' name="conteudo" > <?=htmlspecialchars_decode($colunas->conteudo)?> </textarea>

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
        ajaxLoadPage(null, "get", "ajax/<?=$_PAGE_FORM?>", "id="+id+"&excluir=1&especie_id=<?=$_REQUEST["especie_id"]?>");
    }
</script>