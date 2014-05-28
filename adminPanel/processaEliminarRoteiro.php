<?php

include '../includes/config.php';

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql_file = "SELECT imagem FROM roteiro WHERE id = " . $id_get_parametro;
$filename = @mysql_fetch_assoc(mysql_query($sql_file));
$filename = $filename['imagem'];

$sql = "DELETE FROM roteiro WHERE id = " . $id_get_parametro;

if (mysql_query($sql)) {

    $image_dir = 'img';
    $image_dir_path = getcwd() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $image_dir;

    $targets = array($image_dir_path . DIRECTORY_SEPARATOR . $filename,
        $image_dir_path . DIRECTORY_SEPARATOR . 'gd_' . $filename,
        $image_dir_path . DIRECTORY_SEPARATOR . 'pq_' . $filename
    );

    foreach ($targets as $target) {
        if (file_exists($target)) {
            unlink($target);
        }
    }
    echo json_encode(array("erro" => false, "mensagem" => "O roteiro foi eliminado com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível eliminar o roteiro."));
}
?>