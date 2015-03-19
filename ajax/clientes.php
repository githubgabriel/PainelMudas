<?php ob_start();
include "../BASEV2/basev2.php"; getBaseV2("php",".");

use base\ambiente_restrito\ambiente_restrito;
use base\gerenciar_mudas\clientes;

/* Verifica se Sessao do Login está ativa ! */
ambiente_restrito::isLogged();

?>
<button style="margin-bottom:10px;" onclick="return novo_registro();"> NOVO REGISTRO </button>
<table border="1" class="table_style">
    <thead>
    <tr>
        <td width="20">ID</td>
        <td>NOME COMPLETO</td>
        <td>EMAIL</td>
        <td width="150">TELEFONES</td>
        <td width="100">OPÇÕES</td>
    </tr>
    </thead>
    <tbody>

    <?
    $obj = new clientes();
    try {
        $p = $conexao->prepare($obj->getTableHtml());
        $p->execute();

        while($row = $p->fetchObject()) {

            echo " <tr>
        <td>{$row->id}</td>
        <td>{$row->nome_completo}</td>
        <td>{$row->email}</td>
        <td>{$row->telefone}</td>
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

        ajaxLoadPage(null, "get", "ajax/clientes_Form.php", null);

        return false;
    }

    function editar(id) {
        ajaxLoadPage(null, "get", "ajax/clientes_Form.php", "id="+id);
    }

</script>