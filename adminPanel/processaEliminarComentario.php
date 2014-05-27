<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "DELETE FROM comentario WHERE id = " . $id_get_parametro;

if (mysql_query($sql)) {

    echo "comentario eliminado com sucesso! redireccionar";
} else {
    echo "insucesso " . mysql_error();
}
?>