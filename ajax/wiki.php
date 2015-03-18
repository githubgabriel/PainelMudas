<?php ob_start();
include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
//use base\gerenciar_mudas\especiesFamilia;
use base\gerenciar_mudas\wikiMudas;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();

?>
<button style="margin-bottom:10px;" onclick="return novo_registro();"> NOVO REGISTRO </button>

<table border="1" class="table_style">
    <thead>
    <tr>
        <td width="20">ID</td>
        <td >TITULO</td>
        <td width="100">DATA CRIAÇÃO</td>
        <td width="20">OPÇÕES</td>
    </tr>
    </thead>
    <tbody>

    <?
    $obj = new wikiMudas();
    $obj->setIdEspecie($_GET["id"]);
    try {
        $p = $conexao->prepare($obj->getTableHtml());
        $p->execute();

        while($row = $p->fetchObject()) {

            echo "<tr>
                <td>{$row->id}</td>
                <td style='text-align:left;'> {$row->titulo}</td>
                <td>".parseDataHoraBR($row->data_criacao)."</td>
                <td> <button onclick='return editar({$row->id});'> EDITAR </button> </td>
            </tr>";

        }

    } catch (Exception $e) {
        echo $e->getMessage(); die();
    }
    ?>

    </tbody>
</table>
<br>
<br>
<center> <?=$p->rowCount();?> Registros. </center>

<script>
    function novo_registro() {

        ajaxLoadPage(null, "get", "ajax/wiki_Form.php", "especie_id=<?=$_GET["id"]?>");

        return false;
    }

    function editar(id) {
        ajaxLoadPage(null, "get", "ajax/wiki_Form.php", "id="+id+"&especie_id=<?=$_GET["id"]?>");
    }

</script>