<ul id="btnInserirRoteiro">
    <a href="index.php?p=inserir"><li>Inserir Roteiro</li></a>
</ul>

<ul id="ultimaUl">
    <a href="index.php?p=gerirRoteiros"><li>Gerir Roteiros</li></a>

    <a href="index.php?p=gerirComentarios"><li>Gerir Comentários</li></a>

    <a href="index.php?p=gerirUtilizadores"><li>Gerir Utilizadores</li></a>
    <br><br>
    <a href="index.php?p=editarTermosCondicoes"><li>Editar Termos & Condições</li></a>
</ul>

<ul id="ulEstadoRoteiros">
    <?php
    switch (@$_GET['p']) {
        case 'editar_roteiro':
            include 'includes/estadoRoteiro.php';
            break;
        case 'editar_comentario':
            include 'includes/estadoComentario.php';
            break;
        case 'editar_utilizador':
            include 'includes/estadoUtilizador.php';
            break;
    }
    ?>
</ul>