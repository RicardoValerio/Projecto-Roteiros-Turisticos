<?php

include '../includes/config.php';

$estadoUpdate = ($_POST['estado']) ? 0 : 1;

$sql = "UPDATE comentario SET ativo = " . $estadoUpdate . ' WHERE id = ' . $_POST['id'];

mysql_query($sql);


?>
