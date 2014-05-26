<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT * FROM comentario WHERE id = $id_get_parametro";

$result_estado_do_comentario = mysql_query($sql);
if (@mysql_num_rows($result_estado_do_comentario)) { ?>
    <div id="eliminarRoteiroId">
        <a href="processaEliminarComentario.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Comentário</a>
    </div>

<?php } ?>

<script>

    $(document).ready(function() {
        $('#myEliminarRoteiro').on('click', function() {
            return confirm("Tem a certeza que pretende eliminar este comentário?");
        });
    });
</script>


