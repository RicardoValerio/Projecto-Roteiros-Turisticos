<ul id="btnInserirRoteiro">
    <a href="index.php?area=inserir"><li>Inserir Roteiro</li></a>
</ul>

<ul id="ultimaUl">
    <a href="index.php?area=gerirRoteiros"><li>Gerir Roteiros</li></a>

    <a href="index.php?area=gerirComentarios"><li>Gerir Comentários</li></a>

    <a href="index.php?area=gerirUtilizadores"><li>Gerir Utilizadores</li></a>
</ul>

<ul id="btnTermosCondicoes">
    <a href="index.php?area=editarTermosCondicoes"><li>Editar Termos & Condições</li></a>
</ul>

<ul id="ulEstadoRoteiros">
    <?php
    if (isset($_GET['area'])) {
        switch ($_GET['area']) {
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
    }
    ?>
</ul>