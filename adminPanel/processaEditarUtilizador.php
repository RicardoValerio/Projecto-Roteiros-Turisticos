<?php
include '../includes/config.php';


$post_parametro_id_utilizador = mysql_real_escape_string($_POST['i']);
$post_parametro_id_tipo_utilizador = mysql_real_escape_string($_POST['tipo_utilizador']);
$post_parametro_nome_utilizador = mysql_real_escape_string(utf8_decode($_POST['nome_utilizador']));
$post_parametro_email_utilizador = mysql_real_escape_string($_POST['email_utilizador']);


$sql = "UPDATE utilizador
		SET id_tipo_utilizador =  $post_parametro_id_tipo_utilizador,
			nome = '$post_parametro_nome_utilizador',
			email = '$post_parametro_email_utilizador'
		WHERE id = $post_parametro_id_utilizador";



if (mysql_query($sql)) {
// redirecionar no futuro
    echo "sucesso, foi tudo actualizado com tranquilidade xD - redirrecionar no futuro...<br><br>";
} else {
    echo "erro! contacte a empresa a quem pagou por esta porcaria de software..." . mysql_error();
}
?>