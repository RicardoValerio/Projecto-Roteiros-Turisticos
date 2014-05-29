<?php
require_once 'includes/config.php';
session_start();

if (isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"])) {
   
    $roteiro = $_SESSION['roteiro'];
    $utilizador = $_SESSION['id_utilizador'];
    $comentar = mysql_real_escape_string(utf8_decode(nl2br($_POST['comentar'])));
    
    $sql = "INSERT INTO comentario (id_roteiro, id_utilizador, comentario) VALUES ($roteiro, $utilizador, '$comentar')";
    
    mysql_query($sql);
}

header("Location: " . $_SESSION['url']);
exit;
?>
