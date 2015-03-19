<?php ob_start();

include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\vendas;
use base\gerenciar_mudas\clientes;
//use base\upload\upload;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();


$_PAGE_LIST = "vendas.php";
$_PAGE_FORM = "vendas_Form.php";


/* INSERT ou UPDATE */
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_NUMBER_INT);
    $cliente_id = filter_input(INPUT_POST,"cliente_id",FILTER_SANITIZE_STRING);
    $texto = filter_input(INPUT_POST,"texto",FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST,"valor",FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST,"status",FILTER_SANITIZE_STRING);

    if($cliente_id and $valor) {

        $obj = new vendas();

        $obj->setId($id);
        $obj->setClienteId($cliente_id);
        $obj->setTexto($texto);
        $obj->setValor($valor);
        $obj->setStatus($status);

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

        $obj = new vendas();

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

    $obj = new vendas();

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
        <label> Cliente </label>
        <br>
        <select name="cliente_id">
            <?
                $clienteObj = new clientes();

            $p = $conexao->prepare($clienteObj->getTableHtml());
            $p->execute();

            while($row = $p->fetchObject()) {

                echo " <option value='{$row->id}'> {$row->nome_completo} </option>";

            }

            ?>
        </select>
    </div>

<script>
    $("select[name=cliente_id]").val('<?=(!$colunas->cliente_id)?"":$colunas->cliente_id;?>');

    $("select[name=cliente_id]").chosen({width:"95%"});

</script>



    <div id="form" class="wid50">

        <label> Valor R$: </label>
        <br>
        <input type="text" name="valor" value="<?=$colunas->valor?>" />

    </div>



    <div class="clear"> </div>


    <div id="form">

        <label> Obs: </label>
        <br>
        <textarea type="text" style="  width: 100%;
  min-height: 100px;" name="texto" > <?=$colunas->texto?> </textarea>

    </div>

    <div id="form">

        <label> Status: </label>
        <br>

        <select name="status" >

            <option value="0"> Pendente </option>
            <option value="1"> Pago </option>

        </select>

        <script>
            $("select[name=status]").val('<?=(!$colunas->status)?"0":$colunas->status;?>');

        </script>


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