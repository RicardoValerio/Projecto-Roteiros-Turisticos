<h1 style="font-size: 3em;
color:#D3109F;
text-align: center;
margin-top: 75px;
">Editar Comentário</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <?php

    $id_get_parametro = mysql_real_escape_string($_GET['id']);

    $sql = "SELECT
                comentario.id,
                utilizador.nome,
                utilizador.email,
                roteiro.titulo,
                comentario.data,
                comentario.comentario
            FROM
                utilizador,
                comentario,
                roteiro
            WHERE
                utilizador.id = comentario.id_utilizador
            AND roteiro.id = comentario.id_roteiro
            AND comentario.id = $id_get_parametro";

    $result_comentarios = mysql_query($sql);

    ?>

    <?php if (@mysql_num_rows($result_comentarios)): ?>


    <?php $row_comentario = mysql_fetch_assoc($result_comentarios); ?>

    <form id="formEditarComentario" action="processaEditarComentario.php" method="post">



        <h2> Comentário com Id # <?php echo $row_comentario['id']; ?></h2>
        <input type="hidden" name="i" value="<?php echo $row_comentario['id']; ?>">

<hr>
        <p>
            <label for="utilizador">Autor do Comentário:</label>
            <h5><?php echo $row_comentario['nome'];  ?></h5>
            <h5><?php echo $row_comentario['email'];  ?></h5>
        </p>
<hr>

        <p>
            <label for="nome">Nome/Título do Roteiro:</label>
            <h3><?php echo $row_comentario['titulo'];  ?></h3>
        </p>

<hr>
        <p>
            <label for="utilizador">Data do Comentário:</label>
            <h5><?php echo $row_comentario['data'];  ?></h5>
        </p>
<hr>

        <p>
            <label for="descricao">Comentário:</label>
            <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="comentario" id="descricao" placeholder="Insira uma breve descrição sobre o roteiro...">
                <?php echo $row_comentario['comentario']; ?>
            </textarea>
        </p>

        <input class="mySubmitButton" type="submit" value="Atualizar Comentário" />

    </form>

    <script>
    $(function() {
        $('#palavras_chave').tagsInput({width: 'auto'});
    });

    </script>

    <script>
    CKEDITOR.replace('descricao');
    CKEDITOR.replace('como_chegar');
    CKEDITOR.replace('sobre');
    CKEDITOR.replace('infos_uteis');
    </script>

</div>


<?php else: ?>
    <?php echo "Bazinga!, Esse id não existe na BD"; ?>
<?php endif ?>