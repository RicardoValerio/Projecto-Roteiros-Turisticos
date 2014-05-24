<?php

$id_get_parametro = mysql_real_escape_string($_GET['id']);

$sql = "SELECT ativo FROM roteiro WHERE id = $id_get_parametro";

$result_estado_do_roteiro = mysql_query($sql);
?>

<?php if (@mysql_num_rows($result_estado_do_roteiro)): ?>

	<?php
		$result_ativo_ou_inactivo = @mysql_fetch_assoc(mysql_query($sql));

		$sql = "SELECT ativo FROM roteiro WHERE id = $id_get_parametro";
		$result_ativo_ou_inactivo = @mysql_fetch_assoc(mysql_query($sql));
	 ?>

		<?php if ($result_ativo_ou_inactivo['ativo'] == 1): ?>

		<p id="notaEstado">Clique para Desativar o Roteiro:</p>
			<div id="estadoRoteiro">
				<div id="myRoteiroActivo" class="roteiroActivo">Roteiro Activo</div>
			</div>

		<?php else: ?>

		<p id="notaEstado">Clique para Ativar o Roteiro:</p>
			<div id="estadoRoteiro">
				<div id="myRoteiroInactivo" class="roteiroInactivo">Roteiro Inactivo</div>
			</div>

		<?php endif ?>

<?php endif ?>

<script>

$(document).ready(function() {

	setInterval(function() {


			$('#myRoteiroInactivo').on('click', function () {

				$.ajax({
						url: 'testarUpdateEstadoRoteiro.php',
						type: 'post',
						data: { id: <?php echo $_GET['id']; ?>,
								estado: 0},
						success: function (data) {
							$('#estadoRoteiro').html('<div id="myRoteiroActivo" class="roteiroActivo">Roteiro Activo</div>');
							$('#notaEstado').html('Clique para Desativar o Roteiro');
						}
					});
			});

			$('#myRoteiroActivo').on('click', function () {

				$.ajax({
						url: 'testarUpdateEstadoRoteiro.php',
						type: 'post',
						data: { id: <?php echo $_GET['id']; ?>,
								estado: 1},
						success: function (data) {
							console.log(data);
							$('#estadoRoteiro').html('<div id="myRoteiroInactivo" class="roteiroInactivo">Roteiro Inactivo</div>');
							$('#notaEstado').html('Clique para Ativar o Roteiro:');
						}
					});


			});

	}, 100);

});


</script>


