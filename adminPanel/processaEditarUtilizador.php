<?php

require_once '../includes/config.php';


$post_parametro_id_utilizador = mysql_real_escape_string($_POST['i']);
$post_parametro_id_tipo_utilizador = mysql_real_escape_string($_POST['tipo_utilizador']);
$post_parametro_nome_utilizador = mysql_real_escape_string(utf8_decode($_POST['nome_utilizador']));
$post_parametro_email_utilizador = mysql_real_escape_string($_POST['email_utilizador']);

if (strlen(trim($post_parametro_nome_utilizador)) == 0 && strlen(trim($post_parametro_email_utilizador)) == 0) {
    echo json_encode(array("erro" => true, "mensagem" => "Preencha o nome do utilizador.<br /><br />Preencha o email do utilizador."));
    exit();
} else {
    if (strlen(trim($post_parametro_nome_utilizador)) == 0) {
        echo json_encode(array("erro" => true, "mensagem" => "Preencha o nome do utilizador."));
        exit();
    } else if (strlen(trim($post_parametro_email_utilizador)) == 0) {
        echo json_encode(array("erro" => true, "mensagem" => "Preencha o email do utilizador."));
        exit();
    }
}


$sql = "UPDATE utilizador
		SET id_tipo_utilizador =  $post_parametro_id_tipo_utilizador,
			nome = '$post_parametro_nome_utilizador',
			email = '$post_parametro_email_utilizador'
		WHERE id = $post_parametro_id_utilizador";

if (mysql_query($sql)) {
    echo json_encode(array("erro" => false, "mensagem" => "O utilizador foi alterado com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível alterar o utilizador."));
}
?>