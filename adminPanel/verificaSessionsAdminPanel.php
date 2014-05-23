<?php

if (!( isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"]) && $_SESSION["tipo_utilizador"] == 'admin' )) {
     header("Location: ../index.php ");
    exit;
}
?>