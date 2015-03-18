<?php ob_start();
include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\especiesFamilia;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();


$_PAGE_LIST = "estoque_mudas.php";
//$_PAGE_FORM = "estoque_mudas_Fo.php";

if($_POST["ColunaValor"] and $_POST["id"]) {

    $obj = new especiesFamilia();

    $p = $conexao->prepare($obj->updateColunaByID($_POST["ColunaValor"],$_POST["UpdateValor"],$_POST["id"]));
    $p->execute();

}


?><!--
<button style="margin-bottom:10px;" onclick="return novo_registro();"> NOVO REGISTRO </button>
-->
<table border="1" class="table_style">
    <thead>
    <tr>
        <td width="20">ID</td>
        <td>ESPECIE</td>
        <td>FAMILIA</td>
        <td width="50">WIKI</td>
        <td width="100">QTD/PEQUENO</td>
        <td width="100">QTD/MEDIO</td>
        <td width="100">QTD/GRANDE</td>
    </tr>
    </thead>
    <tbody>

    <?
    $obj = new especiesFamilia();
    try {
        $p = $conexao->prepare($obj->getTableHtml());
        $p->execute();

        while($row = $p->fetchObject()) {

            $total_pequeno += $row->qtd_pequeno;
            $total_medio += $row->qtd_medio;
            $total_grande += $row->qtd_grande;

                echo " <tr>
            <td> {$row->id}</td>
            <td> {$row->especie}</td>
            <td> {$row->familia}</td>
            <td> <a href='#' onclick='return abreWiki({$row->id})'><button>Docs</button></a></td>
            <td> <button onclick=\"return updateQTD({$row->id},'qtd_pequeno');\">{$row->qtd_pequeno}</button> </td>
            <td> <button onclick=\"return updateQTD({$row->id},'qtd_medio');\">{$row->qtd_medio}</button> </td>
            <td> <button onclick=\"return updateQTD({$row->id},'qtd_grande');\">{$row->qtd_grande}</button> </td>
            </tr>";

        }

        echo " <tr>
            <td colspan='4'>  Total de Mudas: </td>
            <td> <b> {$total_pequeno} </b> </td>
            <td> <b> {$total_medio} </b>  </td>
            <td> <b> {$total_grande} </b> </td>
            </tr>";




    } catch (Exception $e) {
        echo $e->getMessage(); die();
    }
    ?>

    </tbody>
</table>


<script>

    function updateQTD(id,coluna) {

        var pr = prompt("Atualizar Quantidade para:");

        if(pr) {

                var data = new FormData();
                data.append("UpdateValor", pr);
                data.append("ColunaValor", coluna);
                data.append("id", id);

                ajaxLoadPage(null, "post", "ajax/<?=$_PAGE_LIST?>", data );

        }
    }

    /*function novo_registro() {

        ajaxLoadPage(null, "get", "ajax/especiesfamilias_Form.php", null);

        return false;
    }*/

    /*function editar(id) {
        ajaxLoadPage(null, "get", "ajax/especiesfamilias_Form.php", "id="+id);
    }*/



</script>