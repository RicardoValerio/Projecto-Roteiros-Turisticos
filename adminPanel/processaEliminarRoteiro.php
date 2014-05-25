<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql_file = "SELECT imagem FROM roteiro WHERE id = " . $id_get_parametro;
$filename = @mysql_fetch_assoc(mysql_query($sql_file));
$filename = $filename['imagem'];

echo $filename;
die;

$sql = "DELETE FROM roteiro WHERE id = " . $id_get_parametro;

?>

<?php if (mysql_query($sql)): ?>

<?php
        $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($target)) {
            unlink($target);
        }

?>



	<?php echo "roteiro eliminado com sucesso! redireccionar" ?>

<?php else: ?>
	<?php echo "insucesso! redireccionar " . mysql_error(); ?>
<?php endif ?>