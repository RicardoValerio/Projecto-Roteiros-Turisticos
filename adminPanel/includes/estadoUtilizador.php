<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo, bloqueado FROM utilizador WHERE id = $id_get_parametro";

$result_estado_do_utilizador = mysql_query($sql);

if (@mysql_num_rows($result_estado_do_utilizador)) {
    ?>

    <?php $result = @mysql_fetch_assoc($result_estado_do_utilizador); ?>

    <p id="notaEstado"><?php echo ($result['ativo'] == 1) ? 'Clique para Desativar o Utilizador:' : 'Clique para Ativar o Utilizador:'; ?></p>
    <div id="estadoUtilizador">
        <div id="<?php echo ($result['ativo'] == 1) ? 'myUtilizadorActivo' : 'myUtilizadorInactivo'; ?>" class="<?php echo ($result['ativo'] == 1) ? 'utilizadorActivo' : 'utilizadorInactivo'; ?>"><?php echo ($result['ativo'] == 1) ? 'O Utilizador Está Ativo' : 'O Utilizador Está Inativo'; ?></div>
    </div>

    <p id="notaBloqueado"><?php echo ($result['bloqueado'] == 0) ? 'Clique para Bloquear o Utilizador:' : 'Clique para Desbloquear o Utilizadors:'; ?></p>
    <div id="estadoUtilizadorBloqueado">
        <div id="<?php echo ($result['bloqueado'] == 0) ? 'myUtilizadorDesbloqueado' : 'myUtilizadorBloqueado'; ?>" class="<?php echo ($result['bloqueado'] == 0) ? 'utilizadorDesbloqueado' : 'utilizadorBloqueado'; ?>"><?php echo ($result['bloqueado'] == 0) ? 'O Utilizador Está Desbloqueado' : 'O Utilizador Está Bloqueado'; ?></div>
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
                    url: 'ajaxUpdateEstadoUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 1},
                    dataType: "json",
                    success: function(data) {
                        $('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroInactivo" class="roteiroActivo">O Utilizador Está Ativo</div>');
                        $('#notaEstado').html('Clique para Desativar o Utilizador');
                    }
                });
            });

            $('#myRoteiroActivo').on('click', function() {

                $.ajax({
                    url: 'ajaxUpdateEstadoUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 0},
                    dataType: "json",
                    success: function(data) {
                        $('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroActivo" class="roteiroInactivo">O Utilizador Está Inativo</div>');
                        $('#notaEstado').html('Clique para Ativar o Utilizador:');
                    }
                });


            });

        }, 100);



        /*setInterval(function() {
         $('#myUtilizadorActivo').on('click', function() {
         
         $.ajax({
         url: 'processaBloquearUtilizador.php',
         type: 'post',
         data: {id: <?php echo $id_get_parametro; ?>,
         estado: 0},
         success: function(data) {
         $('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroActivo" class="roteiroActivo">O Utilizador Está Ativo</div>');
         $('#notaEstadoUtilizador').html('Clique para Desativar o Utilizador');
         }
         });
         });
         
         $('#myUtilizadorInactivo').on('click', function() {
         
         $.ajax({
         url: 'processaBloquearUtilizador.php',
         type: 'post',
         data: {id: <?php echo $id_get_parametro; ?>,
         estado: 1},
         success: function(data) {
         console.log(data);
         $('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroInactivo" class="roteiroInactivo">O Utilizador Está Inativo</div>');
         $('#notaEstadoUtilizador').html('Clique para Ativar o Utilizador:');
         }
         });
         
         
         });
         
         }, 100);*/

    });


</script>