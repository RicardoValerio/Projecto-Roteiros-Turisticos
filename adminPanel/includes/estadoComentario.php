<?php

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo FROM comentario WHERE id = $id_get_parametro";

$result_estado_do_comentario = mysql_query($sql);
?>

<?php if (@mysql_num_rows($result_estado_do_comentario)): ?>

	<?php $result_ativo_ou_inactivo = @mysql_fetch_assoc($result_estado_do_comentario); ?>

		<?php if ($result_ativo_ou_inactivo['ativo'] == 1): ?>

		<p id="notaEstado">Clique para Desativar o Comentário:</p>
			<div id="estadoRoteiro">
				<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroActivo" class="roteiroActivo">O Comentário Está Ativo</div>
			</div>

		<?php else: ?>

		<p id="notaEstado">Clique para Ativar o Comentário:</p>
			<div id="estadoRoteiro">
				<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroInactivo" class="roteiroInactivo">O Comentário Está Inativo</div>
			</div>

		<?php endif ?>

			<div id="eliminarRoteiroId">
				<a style="margin-top: 62px;" href="processaEliminarComentario.php?id=<?php echo $id_get_parametro ?>" id="myEliminarRoteiro" class="eliminarRoteiro">Eliminar Comentário</a>
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
						url: 'ajaxUpdateEstadoComentario.php',
						type: 'post',
						data: { id: <?php echo $id_get_parametro; ?>,
								estado: 0},
						success: function (data) {
							$('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroActivo" class="roteiroActivo">O Comentário Está Ativo</div>');
							$('#notaEstado').html('Clique para Desativar o Comentário');
						}
					});
			});

			$('#myRoteiroActivo').on('click', function () {

				$.ajax({
						url: 'ajaxUpdateEstadoComentario.php',
						type: 'post',
						data: { id: <?php echo $id_get_parametro; ?>,
								estado: 1},
						success: function (data) {
							console.log(data);
							$('#estadoRoteiro').html('<div style="padding-bottom: 12px; padding-top: 16px;" id="myRoteiroInactivo" class="roteiroInactivo">O Comentário Está Inativo</div>');
							$('#notaEstado').html('Clique para Ativar o Comentário:');
						}
					});


			});

	}, 100);



	$('#myEliminarRoteiro').on('click', function () {
		return confirm("Tem a certeza que pretende eliminar este comentário?");
	});

});


</script>


