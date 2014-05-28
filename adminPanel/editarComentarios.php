<h1 style="font-size: 3em;
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

    if (@mysql_num_rows($result_comentarios)) {


        $row_comentario = mysql_fetch_assoc($result_comentarios);
        ?>

        <form id="formEditarComentario" action="processaEditarComentario.php" method="post">



            <h2> Comentário com Id # <?php echo $row_comentario['id']; ?></h2>
            <input type="hidden" name="i" value="<?php echo $row_comentario['id']; ?>">

            <hr>
            <p>
                <label for="utilizador">Autor do Comentário:</label>
            <h5><?php echo utf8_encode($row_comentario['nome']); ?></h5>
            <h5><?php echo utf8_encode($row_comentario['email']); ?></h5>
            </p>
            <hr>

            <p>
                <label for="nome">Nome/Título do Roteiro:</label>
            <h3><?php echo utf8_encode($row_comentario['titulo']); ?></h3>
            </p>

            <hr>
            <p>
                <label for="utilizador">Data do Comentário:</label>
            <h5><?php echo utf8_encode($row_comentario['data']); ?></h5>
            </p>
            <hr>

            <p>
                <label for="comentario">Comentário:</label>
                <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="comentario" id="comentario">
                    <?php echo utf8_encode($row_comentario['comentario']); ?>
                </textarea>
            </p>

            <input class="mySubmitButton" type="submit" value="Atualizar Comentário" />

        </form>

        <script>
            CKEDITOR.replace('comentario');
        </script>

    </div>


    <?php
} else {
    echo "Esse id não existe na BD";
}
?>
<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#formEditarComentario').bind('submit', function(event) {
                var formData = new FormData($(this)[0]);
                formData.append('comentario', CKEDITOR.instances['comentario'].getData());

                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'processaEditarComentario.php',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        dialogMessageNormal('#dialog_mensage', 'Editar comentário');
                        $('#dialog_text').html(response.mensagem);
                    }
                });
            });
        });
    });
</script>