<?php

include '../includes/config.php';

//Nao verificar se está em branco. Se tiver em branco é como se estivesse apagado
$post_parametro_texto_termo = mysql_real_escape_string(utf8_decode($_POST['termos']));

$local = "termos_condicoes";

$sql_verificaExiste = "SELECT local FROM texto WHERE local = '$local'";
$result_verificaExiste = mysql_query($sql_verificaExiste);

if (@mysql_num_rows($result_verificaExiste)) {
    $sql = "UPDATE texto
		SET texto.texto = '$post_parametro_texto_termo'
		WHERE texto.local = '$local'";
} else {
    $sql = "INSERT INTO texto (local, texto) VALUES ('$local', '$post_parametro_texto_termo')";
}

if (mysql_query($sql)) {
    echo json_encode(array("erro" => false, "mensagem" => "Os termos e condições foram alterados com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível alterar os termos e condições."));
}
?>