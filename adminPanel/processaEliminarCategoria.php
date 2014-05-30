<?php

require_once '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "DELETE FROM categoria WHERE id = " . $id_get_parametro;

if (mysql_query($sql)) {
    echo json_encode(array("erro" => false, "mensagem" => "A Categoria foi eliminada com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível eliminar a Categoria."));
}
?>