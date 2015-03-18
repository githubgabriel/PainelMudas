<?php ob_start();
include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\especiesFamilia;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();

?>
<button style="margin-bottom:10px;" onclick="return novo_registro();"> NOVO REGISTRO </button>
<table border="1" class="table_style">
    <thead>
    <tr>
        <td width="20">ID</td>
        <td width="90">IMG</td>
        <td>ESPECIE</td>
        <td>FAMILIA</td>
        <td width="50">WIKI</td>
        <td width="100">OPÇÕES</td>
    </tr>
    </thead>
    <tbody>

    <?
        $obj = new especiesFamilia();
        try {
            $p = $conexao->prepare($obj->getTableHtml());
            $p->execute();

            while($row = $p->fetchObject()) {

                echo " <tr>
        <td>{$row->id}</td>
        <td>";

                if($row->file) {
                     echo '<div style="width:70px;height:70px; margin:10px; background: url('.$obj->getDirUpload().$row->file.') center center;background-size:cover;"></div>' ;
                 } else { echo "Sem Imagem"; }

    echo "</td>
        <td>{$row->especie}</td>
        <td>{$row->familia}</td>
        <td><a href='#' onclick='return abreWiki({$row->id})'><button>Docs</button></a></td>
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

        ajaxLoadPage(null, "get", "ajax/especiesfamilias_Form.php", null);

        return false;
    }

    function editar(id) {
        ajaxLoadPage(null, "get", "ajax/especiesfamilias_Form.php", "id="+id);
    }

</script>