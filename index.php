<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/funcoes_areas.php';
require_once 'includes/funcoes_email.php';
require_once 'includes/funcoes.php';


$_SESSION['url'] = devolveUrlActual();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?php echo verificaAreaIndex('titulo'); ?></title>
        <meta name="viewport" content="width=device-width">

        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="css/plugin.tags.css" />

        <link href="css/estilos.css" rel="stylesheet" type="text/css">
        <link href="css/dialogStyle.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/main.js"></script>


        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <script type="text/javascript" src="js/dialogMessage.js"></script>
        <script type="text/javascript" src="js/votacao.js"></script>
        <script type="text/javascript" src="js/newsletter.js"></script>
        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript" src="js/registo.js"></script>
        <script type="text/javascript" src="js/search.js"></script>
        <script type="text/javascript" src="js/slideshow.js"></script>

        <script src="ckeditor/ckeditor.js"></script>

    </head>

    <body>
        <div id="all">

            <div class="clearfix" id="header">
                <?php include 'header.php'; ?>
            </div>


            <!-- slideshow ou banner -->
            <?php include('includes/' . verificaAreaIndex('banner')); ?>

            <!-- AREAS -->
            <?php include(verificaAreaIndex('linkNavegacao')); ?>
            
            <div id="info" class="clearfix">
                <?php include 'info.php'; ?>
            </div>

            <div id="footer">
                <?php include 'footer.php'; ?>
            </div>

        </div>

        <?php
        if (isset($_GET['log'])) {
            if ($_GET['log'] == 'login') {
                include 'login.php';
            } else if ($_GET['log'] == 'registo') {
                include 'registo.php';
            }
        }

        include 'includes/dialogMessage.php';
        include 'includes/formRecuperarPassword.php';
        ?>
    </body>
</html>