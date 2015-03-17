<?php ob_start();

include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\especiesFamilia;
use base\upload\upload;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();



$_PAGE_LIST = "especiesfamilias.php";
$_PAGE_FORM = "especiesfamilias_Form.php";


/* INSERT ou UPDATE */
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $familia = filter_input(INPUT_POST,"familia",FILTER_SANITIZE_STRING);
    $especie = filter_input(INPUT_POST,"especie",FILTER_SANITIZE_STRING);
    $file = $_FILES["file"];

    if($familia or $especie) {

            $obj = new especiesFamilia();

            $obj->setId($id);
            $obj->setEspecieNome($especie);
            $obj->setFamiliaNome($familia);

            /* Upload File */
            $fileOK = upload::upload(null, $file, "./../BASEV2/php/upload/especiesFamilia/", "jpg,jpeg,gif,png");
            $obj->setImagemFile($fileOK);

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

        $obj = new especiesFamilia();

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

    $obj = new especiesFamilia();

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
        <label> Nome Especie </label>
        <br>
        <input type="text" name="especie" value="<?=$colunas->especie?>" />
    </div>

    <div id="form" class="wid50">

        <label> Nome Familia </label>
        <br>
        <input type="text" name="familia" value="<?=$colunas->familia?>" />

    </div>

    <div class="clear"> </div>


    <div id="form">

        <label> Imagem </label>
        <br>
        <? if($colunas->file) { ?>
            <img height="250" style='margin-bottom:10px; margin-top:10px;margin-right:15px;' src="<?=$obj->getDirUpload()?><?=$colunas->file;?>"> <br>
        <? } ?>
        <input type="file" id="upload" name="file" />

    </div>


<br>
    <div id="form">
        <input type="submit" value="Registrar" />
    </div>

</form>

<script>
    function enviaForm() {

        fileData = new FormData($("form")[0]);

        ajaxLoadPage(null, "post", "ajax/especiesfamilias_Form.php", fileData);

        return false;
    }

    function deletar(id) {
        ajaxLoadPage(null, "get", "ajax/especiesfamilias_Form.php", "id="+id+"&excluir=1");
    }
</script>