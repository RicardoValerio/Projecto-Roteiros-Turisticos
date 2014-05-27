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
        setInterval(function() {
            
            $('#myUtilizadorInactivo').on('click', function() {
                $.ajax({
                    url: 'ajaxUpdateEstadoUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 0},
                    success: function(response) {
                        if (!response.erro) {
                            console.log(response);
                            $('#estadoUtilizador').html('<div id="myUtilizadorActivo" class="utilizadorActivo">O Utilizador Está Ativo</div>');
                            $('#notaEstado').html('Clique para Desativar o Utilizador:');
                        }
                    }
                });
            });
            
            $('#myUtilizadorActivo').on('click', function() {
                $.ajax({
                    url: 'ajaxUpdateEstadoUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 1},
                    success: function(response) {
                        if (!response.erro) {
                            console.log(response);
                            $('#estadoUtilizador').html('<div id="myUtilizadorInactivo" class="utilizadorInactivo">O Utilizador Está Inativo</div>');
                            $('#notaEstado').html('Clique para Ativar o Utilizador:');
                        }
                    }
                });
            });
            
            
            
            
            $('#myUtilizadorBloqueado').on('click', function() {
                $.ajax({
                    url: 'processaBloquearUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 1},
                    success: function(response) {
                        if (!response.erro) {
                            console.log(response);
                            $('#estadoUtilizadorBloqueado').html('<div id="myUtilizadorDesbloqueado" class="utilizadorDesbloqueado">O Utilizador Está Desbloqueado</div>');
                            $('#notaBloqueado').html('Clique para Bloquear o Utilizador:');
                        }
                    }
                });
            });
            
            $('#myUtilizadorDesbloqueado').on('click', function() {
                $.ajax({
                    url: 'processaBloquearUtilizador.php',
                    type: 'post',
                    data: {id: <?php echo $id_get_parametro; ?>, estado: 0},
                    success: function(response) {
                        if (!response.erro) {
                            console.log(response);
                            $('#estadoUtilizadorBloqueado').html('<div id="myUtilizadorBloqueado" class="utilizadorBloqueado">O Utilizador Está Bloqueado</div>');
                            $('#notaBloqueado').html('Clique para Desbloquear o Utilizador:');
                        }
                    }
                });
            });

        }, 100);
    });
</script>