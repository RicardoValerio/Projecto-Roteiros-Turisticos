<?php

include '../includes/config.php';


$post_parametro_id_termos   	 = mysql_real_escape_string($_POST['i']);
$post_parametro_texto_termo      = mysql_real_escape_string($_POST['termos']);


print_r($_POST);
echo "<br />";
echo $post_parametro_texto_termo;
echo "<br />";



$sql = "UPDATE texto
		SET texto.texto = '$post_parametro_texto_termo'
		WHERE texto.id = $post_parametro_id_termos";



if (mysql_query($sql)) {

// redirecionar no futuro
	echo "sucesso, foi tudo actualizado com tranquilidade xD - redirrecionar no futuro...<br><br>";

}else{
	echo "erro! contacte a empresa a quem pagou por esta porcaria de software..." . mysql_error();
}



?>