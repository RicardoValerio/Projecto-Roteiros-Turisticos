<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "DELETE FROM utilizador WHERE id = " . $id_get_parametro;

?>

<?php if (mysql_query($sql)): ?>

	<?php echo "utilizador eliminado com sucesso! redireccionar" ?>

<?php else: ?>
	<?php echo "insucesso " . mysql_error(); ?>
<?php endif ?>