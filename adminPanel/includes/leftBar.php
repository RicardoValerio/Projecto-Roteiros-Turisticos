<ul id="btnInserirRoteiro">
    <a href="index.php?area=inserir_roteiro"><li>Inserir Roteiro</li></a>
    <br>
    <a href="index.php?area=criar_categoria"><li>Criar Categoria</li></a>
</ul>

<ul id="ultimaUl">
    <a href="index.php?area=gerir_categorias"><li>Gerir Categorias</li></a>

    <a href="index.php?area=gerir_roteiros"><li>Gerir Roteiros</li></a>

    <a href="index.php?area=gerir_comentarios"><li>Gerir Comentários</li></a>

    <a href="index.php?area=gerir_utilizadores"><li>Gerir Utilizadores</li></a>
</ul>

<ul id="btnTermosCondicoes">
    <a href="index.php?area=editar_termosCondicoes"><li>Termos & Condições</li></a>
</ul>

<ul id="ulEstadoRoteiros">
    <?php
    if (isset($_GET['area'])) {
        switch ($_GET['area']) {
            case 'editar_categoria':
                include 'includes/estadoCategoria.php';
                break;
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