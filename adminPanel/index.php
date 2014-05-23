<?php
session_start();
require_once '../includes/config.php';
require_once 'verificaSessionsAdminPanel.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Back Office</title>
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">



    <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/estilosAdminPanel.css">
    <link rel="stylesheet" type="text/css" href="../css/plugin.tags.css" />
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="css/shCore.css">
    <link rel="stylesheet" type="text/css" href="css/demo.css">


    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
    <script type="text/javascript" src="../js/plugin.tags.js"></script>
    <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>

    <script type="text/javascript" language="javascript" src="js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="js/shCore.js"></script>
    <script type="text/javascript" language="javascript" src="js/demo.js"></script>
    <script type="text/javascript" language="javascript" class="init">


$(document).ready(function() {
    $('#example').dataTable( {
        "columnDefs": [
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                "render": function ( data, type, row ) {
                    return data +' ('+ row[3]+')';
                },
                "targets": 0
            },
            { "visible": false,  "targets": [ 3 ] }
        ]
    } );
} );


    </script>
    <script src="../ckeditor/ckeditor.js"></script>

</head>

<body>

    <div class="topFixedBar" style="background-color: #273A43;
    height: 62px;
    position: fixed;
    z-index: 99;
    width: 100%;
    ">
    <div style="float: left;
    margin-left: 40px;
    margin-top: -3px;">
    <h2 style="color: white; text-align: center;"><?php echo 'Hello <em style="color: orange">' . $_SESSION['nome'] . '</em>'; ?></h2>
</div>

<ul style="float: right;
margin-right: 50px;
margin-top: 25px;
">
<a href="../index.php"><li>Site</li></a>
<a href="../logout.php"><li>Logout</li></a>
</ul>
</div>

<div class="left">
            <!--
                    <div style="height: 300px;
                                            margin: 60px auto;
                                            width: 300px;
                                            ">
                            <img src="http://png-1.findicons.com/files/icons/1072/face_avatars/300/i04.png" alt="avatar">
                    </div>
                -->
                <ul style="margin-top: 110px;">
                    <a href="index.php"><li>Meus Roteiros</li></a>

                    <a href="#"><li>Meus Comentários</li></a>
                </ul>


                <ul>
                    <a href="index.php?p=inserir"><li>Inserir Roteiro</li></a>
                </ul>


                <?php if ($_SESSION['tipo_utilizador'] == "admin"): ?>

                <ul id="ultimaUl">
                    <a href="index.php?p=gerirRoteiros"><li>Gerir Roteiros</li></a>

                    <a href="#"><li>Gerir Comentários</li></a>

                    <a href="#"><li>Gerir Utilizadores</li></a>

                    <a href="#"><li>Gerir Conteúdos</li></a>
                </ul>
            <?php endif ?>


        </div>

        <div class="right">

            <?php
            switch (@$_GET['p']) {
                case 'inserir':
                include '../area_inserir_roteiro.php';
                break;
                case 'gerirRoteiros':
                include 'gerirRoteiros.php';
                break;
                default:
                include '../area_inserir_roteiro.php';
            }
            ?>

        </div>

    </body>
    </html>