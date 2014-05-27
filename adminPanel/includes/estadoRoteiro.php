<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo FROM roteiro WHERE id = $id_get_parametro";

$result_estado_do_roteiro = mysql_query($sql);

if (@mysql_num_rows($result_estado_do_roteiro)) { ?>

    <?php $result_ativo_ou_inactivo = @mysql_fetch_assoc($result_estado_do_roteiro); ?>

    <p id="notaEstado"><?php echo ($result_ativo_ou_inactivo['ativo'] == 1) ? 'Clique para Desativar o Roteiro:' : 'Clique para Ativar o Roteiro:'; ?></p>
    <div id="estadoRoteiro">
        <div id="<?php echo ($result_ativo_ou_inactivo['ativo'] == 1) ? 'myRoteiroActivo' : 'myRoteiroInactivo'; ?>" class="<?php echo ($result_ativo_ou_inactivo['ativo'] == 1) ? 'roteiroActivo' : 'roteiroInactivo'; ?>"><?php echo ($result_ativo_ou_inactivo['ativo'] == 1) ? 'O Roteiro Está Ativo' : 'O Roteiro Está Inativo'; ?></div>
    </div>

    <div id="eliminarRoteiroId">
        <a href="processaEliminarRoteiro.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Roteiro</a>
    </div>

<?php } ?>

<script>
    $(document).ready(function() {
        /************************************************************************
         *		update do estado do roteiro via ajax
         ************************************************************************/
        setInterval(function() {
            
            $('#myRoteiroInactivo').on('click', function() {
                $.ajax({
                    url: 'ajaxUpdateEstadoRoteiro.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 0},
                    success: function(response) {
                        if (!response.erro) {
                            $('#estadoRoteiro').html('<div id="myRoteiroActivo" class="roteiroActivo">O Roteiro Está Ativo</div>');
                            $('#notaEstado').html('Clique para Desativar o Roteiro:');
                        }
                    }
                });
            });

            $('#myRoteiroActivo').on('click', function() {
                $.ajax({
                    url: 'ajaxUpdateEstadoRoteiro.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 1},
                    success: function(response) {
                        if (!response.erro) {
                            $('#estadoRoteiro').html('<div id="myRoteiroInactivo" class="roteiroInactivo">O Roteiro Está Inativo</div>');
                            $('#notaEstado').html('Clique para Ativar o Roteiro:');
                        }
                    }
                });
            });

        }, 100);

        $('#myEliminarRoteiro').on('click', function() {
            return confirm("Tem a certeza que pretende eliminar este roteiro?");
        });

    });
</script>


