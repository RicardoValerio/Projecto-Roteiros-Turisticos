<?php

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo FROM roteiro WHERE id = $id_get_parametro";

$result_estado_do_roteiro = mysql_query($sql);
?>

<?php if (@mysql_num_rows($result_estado_do_roteiro)): ?>

	<?php $result_ativo_ou_inactivo = @mysql_fetch_assoc($result_estado_do_roteiro); ?>

		<?php if ($result_ativo_ou_inactivo['ativo'] == 1): ?>

		<p id="notaEstado">Clique para Desativar o Roteiro:</p>
			<div id="estadoRoteiro">
				<div id="myRoteiroActivo" class="roteiroActivo">O Roteiro Está Ativo</div>
			</div>

		<?php else: ?>

		<p id="notaEstado">Clique para Ativar o Roteiro:</p>
			<div id="estadoRoteiro">
				<div id="myRoteiroInactivo" class="roteiroInactivo">O Roteiro Está Inativo</div>
			</div>

		<?php endif ?>

			<div id="eliminarRoteiroId">
				<a href="processaEliminarRoteiro.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Roteiro</a>
			</div>

<?php endif ?>

<script>

$(document).ready(function() {


/************************************************************************
*		update do estado do roteiro via ajax
************************************************************************/

	setInterval(function() {


			$('#myRoteiroInactivo').on('click', function () {

				$.ajax({
						url: 'ajaxUpdateEstadoRoteiro.php',
						type: 'post',
						data: { id: <?php echo $id_get_parametro; ?>,
								estado: 0},
						success: function (data) {
							$('#estadoRoteiro').html('<div id="myRoteiroActivo" class="roteiroActivo">O Roteiro Está Ativo</div>');
							$('#notaEstado').html('Clique para Desativar o Roteiro');
						}
					});
			});

			$('#myRoteiroActivo').on('click', function () {

				$.ajax({
						url: 'ajaxUpdateEstadoRoteiro.php',
						type: 'post',
						data: { id: <?php echo $id_get_parametro; ?>,
								estado: 1},
						success: function (data) {
							console.log(data);
							$('#estadoRoteiro').html('<div id="myRoteiroInactivo" class="roteiroInactivo">O Roteiro Está Inativo</div>');
							$('#notaEstado').html('Clique para Ativar o Roteiro:');
						}
					});


			});

	}, 100);



	$('#myEliminarRoteiro').on('click', function () {
		return confirm("Tem a certeza que pretende eliminar este roteiro?");
	});

});


</script>


