<?php
if (isset($_GET['token'])) {
    $newsletterToken = mysql_real_escape_string($_GET['token']);

    $sql = "UPDATE newsletter SET ativo=1 WHERE hash='$newsletterToken'";


    if (mysql_query($sql)) {
        ?>
        <div id="confirmaNewsletter">
            <h1>Newsletter</h1>
            <h4>O seu endereço de email foi validado.</h4>
            <p>Está a partir deste momento, inscrito na newsletter dos roteiros turísticos.</p>
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
