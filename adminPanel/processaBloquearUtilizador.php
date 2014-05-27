<?php

include '../includes/config.php';

$estadoUpdate = ($_POST['estado']) ? 0 : 1;

$sql = "UPDATE utilizador SET bloqueado = " . $estadoUpdate . ' WHERE id = ' . $_POST['id'];

echo json_encode(array("erro" => !mysql_query($sql)));
?>