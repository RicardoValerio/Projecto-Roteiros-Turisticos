<?php

include '../includes/config.php';

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
    echo "sucesso, foi tudo actualizado com tranquilidade xD - redirrecionar no futuro...<br><br>";
} else {
    echo "erro! contacte a empresa a quem pagou por esta porcaria de software..." . mysql_error();
}
?>
