<?php
if (isset($_GET['token'])) {
    $utilizadorToken = mysql_real_escape_string($_GET['token']);

    $sql = "UPDATE utilizador SET ativo=1 WHERE hash='$utilizadorToken'";


    if (mysql_query($sql)) {
        ?>
        <div id="confirmaUtilizador">
            <h1>Utilizador</h1>
            <h4>O seu endereço de email foi validado.</h4>
            <p>Está a partir deste momento, registado nos roteiros turísticos.</p>
        </div>
        <?php
    } else {
        header('location:index.php');
        exit();
    }
} else {
    header('location:index.php');
    exit();
}
?>
