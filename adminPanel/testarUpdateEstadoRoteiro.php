<?php

include '../includes/config.php';

$estadoUpdate = ($_POST['estado']) ? 0 : 1;

$sql = "UPDATE roteiro SET ativo = " . $estadoUpdate . ' WHERE id = ' . $_POST['id'];

mysql_query($sql);


?>
