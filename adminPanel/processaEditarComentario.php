<?php

include '../includes/config.php';


$post_parametro_id_comentario   = mysql_real_escape_string($_POST['i']);
$post_parametro_comentario      = mysql_real_escape_string($_POST['comentario']);


$sql = "UPDATE comentario
		SET comentario = '$post_parametro_comentario'
		WHERE id = $post_parametro_id_comentario";



if (mysql_query($sql)) {

// redirecionar no futuro
	echo "sucesso, foi tudo actualizado com tranquilidade xD - redirrecionar no futuro...<br><br>";

}else{
	echo "erro! contacte a empresa a quem pagou por esta porcaria de software..." . mysql_error();
}



?>