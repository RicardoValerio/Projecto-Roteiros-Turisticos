<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT * FROM roteiro WHERE roteiro.id_categoria = $id_get_parametro";

$result = mysql_query($sql);

if (@!mysql_num_rows($result)) {
    ?>
    <div id="eliminarRoteiroId">
        <a href="processaEliminarCategoria.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Categoria</a>
    </div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#myEliminarRoteiro').on('click', function(event) {
            event.preventDefault();

            dialogMessageConfirm('#dialog_mensage', 'Eliminar Categoria');
            $('#dialog_text').html("Tem a certeza que deseja apagar esta Categoria?");

            $(':button:contains("Sim")').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: 'processaEliminarCategoria.php?id=<?php echo $id_get_parametro ?>',
                    dataType: "json",
                    success: function(response) {
                        dialogMessageNormal('#dialog_mensage', 'Eliminar Categoria');
                        $('#dialog_text').html(response.mensagem);
                        if (!response.erro) {
                            $('.ui-dialog-buttonset').on('click', function() {
                                window.location.href = "index.php?area=gerir_categorias";
                            });
                        }
                    }
                });
            });
        });
    });
</script>