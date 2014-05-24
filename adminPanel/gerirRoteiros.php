<?php
$sql = "SELECT * FROM roteiro";
$result_roteiros = mysql_query($sql);
?>

<body class="dt-example">
	<div class="container">


		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="sorting">Título</th>
					<th class="sorting">Categoria</th>
					<th class="sorting">Data</th>
					<th class="sorting">Ativo</th>
					<th class="sorting">Editar Roteiro</th>
				</tr>
			</thead>

			<tfoot>
				<tr>
					<th>Título</th>
					<th>Categoria</th>
					<th>Data</th>
					<th>Ativo</th>
					<th>Editar Roteiro</th>
				</tr>
			</tfoot>

			<tbody>

				<?php while ($row_roteiros = mysql_fetch_assoc($result_roteiros)): ?>
					<tr>
						<td class="linhasCentradasTabela"><?php echo $row_roteiros['titulo']; ?></td>
						<td class="linhasCentradasTabela"><?php echo $row_roteiros['id_categoria']; ?></td>
						<td class="linhasCentradasTabela"><?php echo $row_roteiros['data']; ?></td>
						<td class="linhasCentradasTabela"><?php echo $row_roteiros['ativo']; ?></td>
						<td class="linhasCentradasTabela"><a href="index.php?p=editar&id=<?php echo $row_roteiros['id']; ?>" class="editarRoteiro">Editar</a></td>
					</tr>
				<?php endwhile; ?>

			</tbody>
		</table>


	</div>
</section>
</div>

<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
    $('#example').dataTable();

// tive de adicionar isto pois foi a unica forma de conseguir com que a tabela
// fica-se ordenada pela data de forma descendente - pelo sql não deu, deve ser
// devido à forma como o plugin está feito...weird
$('#example').DataTable()
	.order( [ 2, 'desc' ] )
    .draw();

});


</script>


