<?php
include '../includes/config.php';

$post_parametro_id_comentario = mysql_real_escape_string($_POST['i']);
$post_parametro_comentario = mysql_real_escape_string(utf8_decode($_POST['comentario']));

$sql = "UPDATE comentario
		SET comentario = '$post_parametro_comentario'
		WHERE id = $post_parametro_id_comentario";

if (mysql_query($sql)) {
    echo json_encode(array("erro" => false, "mensagem" => "O comentário foi alterado com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível alterar o comentário."));
}
?>