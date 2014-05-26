<?php
$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo, bloqueado FROM utilizador WHERE id = $id_get_parametro";

$result_estado_do_utilizador = mysql_query($sql);

if (@mysql_num_rows($result_estado_do_utilizador)) {
    $linha = mysql_fetch_assoc($result_estado_do_utilizador);

    if ($linha['ativo'] == 1) {
        ?>

        <p id="notaEstado">Clique para Desativar o Utilizador:</p>
        <div id="estadoRoteiro">
            <div id="myRoteiroActivo" class="roteiroActivo">O Utilizador Está Ativo</div>
        </div>

    <?php } else { ?>

        <p id="notaEstado">Clique para Ativar o Utilizador:</p>
        <div id="estadoRoteiro">
            <div id="myRoteiroInactivo" class="roteiroInactivo">O Utilizador Está Inativo</div>
        </div>

    <?php }




    if ($linha['bloqueado'] == 0) {
        ?>

        <p id="notaEstadoUtilizador">Clique para Bloquear o Utilizador:</p>
        <div id="estadoUtilizador">
            <div id="myUtilizadorActivo" class="roteiroActivo">O Utilizador Está Desbloqueado</div>
        </div>

    <?php } else { ?>

        <p id="notaEstadoUtilizador">Clique para Desbloquear o Utilizador:</p>
        <div id="estadoUtilizador">
            <div id="myUtilizadorInactivo" class="roteiroInactivo">O Utilizador Está Bloqueado</div>
        </div>

    <?php }
}
?>

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
                    data: {id: <?php echo $id_get_parametro; ?>,
                        estado: 1},
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
                    data: {id: <?php echo $id_get_parametro; ?>,
                        estado: 0},
                    success: function(data) {
                        console.log(data);
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


