<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "DELETE FROM comentario WHERE id = " . $id_get_parametro;

?>

<?php if (mysql_query($sql)): ?>

	<?php echo "comentario eliminado com sucesso! redireccionar" ?>

<?php else: ?>
	<?php echo "insucesso " . mysql_error(); ?>
<?php endif ?>