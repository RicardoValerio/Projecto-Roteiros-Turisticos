<?php require_once 'verificaSessionsAdminPanel.php'; ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TI</title>
        <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans' rel='stylesheet' type='text/css'>


        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
        <!-- <script type="text/javascript" src="http://xoxco.com/projects/code/tagsinput/jquery.tagsinput.js"></script> -->
        <script type="text/javascript" src="js/plugin.tags.js"></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>

        <!-- <link rel="stylesheet" type="text/css" href="http://xoxco.com/projects/code/tagsinput/jquery.tagsinput.css" /> -->
        <link rel="stylesheet" type="text/css" href="css/plugin.tags.css" />
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />


        <style>
            body{
                font-family: 'Alegreya Sans', sans-serif;
                background-color: #CFCECE;
                width: 100%;
                margin: 0 auto;
            }


            .right{
                width: 70%;
                float: right;
                margin-right: 60px;
            }

            .left{
                float: left;
                width: 25%;
                overflow: auto;
                height: 100%;
                position: fixed;
                background-color: #1F2228;
            }

            .left ul{
                margin-right: 40px;
                margin-bottom: 30px;
                /*margin-left: -33px;*/
            }

            #ultimaUl{
                margin-bottom: 100px;
            }

            .left a{
                text-decoration: none;
            }

            .left ul li{
                list-style-type: none;
                color: #FFFFFF;
                font-weight: bold;
                font-size: 1.1em;
                text-align: center;
                height: 20px;
                border: 1px solid white;
                padding:5px;
            }


            dt{
                font-weight: bold;
                text-transform: capitalize;
                color:red;
                font-size: 2em;
            }

            dd{
                text-indent: 15px;
                border: 2px dashed orange;
                padding:10px;
                margin-bottom: 40px;
                font-size: 1.2em;
                color:white;
            }

            .verde{
                color:#18AB1D;
                font-weight: bolder;
            }

            .amarelo{
                color:#E6E41A;
                font-weight: bolder;
            }

            .roxo:first-line{
                color:#E43BBD;
                font-weight: bolder;
            }

            .azul:first-line{
                color:#249DE4;
                font-weight: bold;
            }

            dd li{
                border: 1px dashed gray;
            }

            * a{
                color: white;
            }

            .duvida{
                background-color: #D75555;
            }

            .percebido{
                background-color: #57D05C;
            }
            .assim-assim{
                background-color: #E4D93B;
            }

            .topFixedBar{
                background-color: #FFFF00;
                height: 50px;
            }

            .topFixedBar ul{
                float: right;
                margin-right: 50px;
            }

            .topFixedBar ul li{
                display: inline;
                margin-right: 50px;
            }

        </style>

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
                    <a href="#"><li>Gerir Roteiros</li></a>

                    <a href="#"><li>Gerir Comentários</li></a>

                    <a href="#"><li>Gerir Utilizadores</li></a>

                    <a href="#"><li>Gerir Conteúdos</li></a>
                </ul>
            <?php endif ?>


        </div>

        <div class="right">