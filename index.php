<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/funcoes_areas.php';
require_once 'includes/funcoes_email.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title><?php echo verificaAreaIndex('titulo'); ?></title>
        <meta name="viewport" content="width=device-width">

        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link href="css/estilos.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">


        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/main.js"></script>

        <script type="text/javascript" src="js/newsletter.js"></script>
        <script type="text/javascript" src="js/search.js"></script>
        <script type="text/javascript" src="js/slideshow.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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


            <!--<div class="separador">
                 <hr />
                <img src="img/separador_certo.jpg" alt="" />
            </div>
            <div id="destinos">
                <h2>Explore <span>destinos</span></h2>
                <p>Sugestões</p>
                <p>Eventos</p>
                <form method="get" action="">
                    <select name="destino">
                        <option>Destino</option>
                    </select>
                    <select name="oQueFazer">
                        <option>O que fazer?</option>
                    </select>
                    <input type="text" name="pesquisa"/>
                    <input type="submit" value="Pesquisar" />
                </form>
            </div>-->

            <div id="info" class="clearfix">
                <?php include 'info.php'; ?>
            </div>

            <div id="footer">
                <?php include 'footer.php'; ?>
            </div>

        </div>

        <div id="lightboxLogin" class="lightboxInativo">
            <?php include 'login.php'; ?>
        </div>

        <div id="lightboxRegisto" class="lightboxInativo">
            <?php include 'registo.php'; ?>
        </div>

    </body>
</html>