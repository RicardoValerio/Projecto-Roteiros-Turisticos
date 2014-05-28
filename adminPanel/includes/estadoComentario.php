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
            //return confirm("Tem a certeza que pretende eliminar este comentário?");

            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'processaEliminarComentario.php?id=<?php echo $id_get_parametro ?>',
                dataType: "json",
                success: function(response) {
                    if (response.erro) {
                        dialogMessageNormal('#dialog_mensage', 'Eliminar comentário');
                        $('#dialog_text').html(response.mensagem);
                    } else {
                        dialogMessageNormal('#dialog_mensage', 'Eliminar comentário');
                        $('#dialog_text').html("O comentário foi eliminado com sucesso.");
                        $('.ui-dialog-buttonset').on('click', function(){
                            window.location.href = "index.php?area=gerir_comentarios&eliminado=sucesso";
                        });
                        
                    }
                }
            });
        });
    });
</script>