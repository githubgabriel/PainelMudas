<?php ob_start();
include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\clientes;
use base\gerenciar_mudas\vendas;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();

?>
<button style="margin-bottom:10px;" onclick="return novo_registro();"> NOVO REGISTRO </button>
<table border="1" class="table_style">
    <thead>
    <tr>
        <td width="20">ID</td>
        <td width="80">DATA</td>
        <td>CLIENTE NOME</td>
        <td width="150">VALOR R$ </td>
        <td width="150">STATUS </td>
        <td width="100">OPÇÕES</td>
    </tr>
    </thead>
    <tbody>

    <?
    $obj = new vendas();
    $clienteObj = new clientes();

    try {
        $p = $conexao->prepare($obj->getTableHtml());
        $p->execute();

        while($row = $p->fetchObject()) {

            $p2 = $conexao->prepare($clienteObj->getRowById($row->cliente_id));
            $p2->execute();
            $clienteRow = $p2->fetchObject();

            $colorStatus = ($row->status == 0)? "color:red;" : "color:green;";
            $row->status = ($row->status == 0)? "<b>PENDENTE</b>" : "<b>PAGO!</b>";

            echo " <tr>
        <td>{$row->id}</td>
        <td>".parseDataHoraBR($row->data_criacao)."</td>
        <td>{$clienteRow->nome_completo}</td>
        <td>{$row->valor}</td>
        <td style='{$colorStatus}'>{$row->status}</td>
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

        ajaxLoadPage(null, "get", "ajax/vendas_Form.php", null);

        return false;
    }

    function editar(id) {
        ajaxLoadPage(null, "get", "ajax/vendas_Form.php", "id="+id);
    }

</script>