<?php
$sql = "SELECT
    comentario.id,
    roteiro.titulo,
    utilizador.nome,
    comentario.comentario,
    comentario.data,
    comentario.ativo
FROM
    roteiro,
    utilizador,
    comentario
WHERE
    roteiro.id = comentario.id_roteiro
        AND utilizador.id = comentario.id_utilizador";

$result_comentarios = mysql_query($sql);
?>

<body class="dt-example">
    <div class="container">

        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="sorting">Nome do Roteiro</th>
                    <th class="sorting">Utilizador</th>
                    <th class="sorting">Comentário</th>
                    <th class="sorting">Data</th>
                    <th class="sorting">Ativo</th>
                    <th class="sorting">Editar Comentário</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Nome do Roteiro</th>
                    <th>Utilizador</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th>Ativo</th>
                    <th>Editar Comentário</th>
                </tr>
            </tfoot>

            <tbody>

                <?php while ($row_comentario = mysql_fetch_assoc($result_comentarios)): ?>
                    <tr>
                        <td class="linhasCentradasTabela"><?php echo $row_comentario['titulo']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_comentario['nome']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_comentario['comentario']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_comentario['data']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_comentario['ativo']; ?></td>
                        <td class="linhasCentradasTabela"><a href="index.php?p=editar_comentario&id=<?php echo $row_comentario['id']; ?>" class="editarRoteiro">Editar</a></td>
                    </tr>
                <?php endwhile; ?>

            </tbody>
        </table>


    </div>
</section>
</div>

<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
    $('#example').dataTable({
          "scrollX": true
    });

// tive de adicionar isto pois foi a unica forma de conseguir com que a tabela
// fica-se ordenada pela data de forma descendente - pelo sql não deu, deve ser
// devido à forma como o plugin está feito...weird
$('#example').DataTable()
    .order( [ 2, 'desc' ] )
    .draw();
});


</script>


