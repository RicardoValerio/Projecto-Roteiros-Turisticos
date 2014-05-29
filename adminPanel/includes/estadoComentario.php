<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT * FROM comentario WHERE id = $id_get_parametro";

$result = mysql_query($sql);

if (@mysql_num_rows($result)) {
    ?>
    <div id="eliminarRoteiroId">
        <a href="processaEliminarComentario.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Comentário</a>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#myEliminarRoteiro').on('click', function(event) {
            event.preventDefault();

            dialogMessageConfirm('#dialog_mensage', 'Eliminar comentário');
            $('#dialog_text').html("Tem a certeza que deseja apagar este comentário?");
            
            $(':button:contains("Sim")').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'processaEliminarComentario.php?id=<?php echo $id_get_parametro ?>',
                    dataType: "json",
                    success: function(response) {
                        dialogMessageNormal('#dialog_mensage', 'Eliminar comentário');
                        $('#dialog_text').html(response.mensagem);
                        if (!response.erro) {
                            $('.ui-dialog-buttonset').on('click', function() {
                                window.location.href = "index.php?area=gerir_comentarios";
                            });
                        }
                    }
                });
            });
        });
    });
</script>