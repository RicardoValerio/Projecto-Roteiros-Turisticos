<?php
session_start();
require_once 'verificaSessionsAdminPanel.php';
require_once '../includes/config.php';
require_once 'includes/funcoes_areas_back_office.php'
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Back Office</title>
        <meta name="viewport" content="width=device-width">

        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">

        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/estilosAdminPanel.css">
        <link rel="stylesheet" type="text/css" href="../css/plugin.tags.css" />
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/shCore.css">
        <link rel="stylesheet" type="text/css" href="css/demo.css">
        
        <script type="text/javascript" src="js/dialogMessage.js"></script>
        <link rel="stylesheet" type="text/css" href="css/dialogStyle.css" />


        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>

        <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/shCore.js"></script>
        <script type="text/javascript" language="javascript" src="js/demo.js"></script>

        <script src="../ckeditor/ckeditor.js"></script>

    </head>

    <body>
        <div class="topFixedBar">
            <?php include 'includes/header.php'; ?>
        </div>

        <div class="left">
            <?php include 'includes/leftBar.php'; ?>
        </div>

        <div class="right">
            <?php include verificaAreaIndexBackOffice(); ?>
        </div>
    </body>
</html>