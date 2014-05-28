<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "DELETE FROM comentario WHERE id = " . $id_get_parametro;

if (mysql_query($sql)) {
    echo json_encode(array("erro" => false, "mensagem" => "O comentário foi eliminado com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível eliminar o comentário."));
}
?>