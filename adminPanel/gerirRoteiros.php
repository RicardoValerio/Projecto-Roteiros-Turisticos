<?php
$sql = "SELECT
	roteiro.id,
    roteiro.titulo,
	categoria.nome,
	roteiro.data,
	roteiro.ativo
FROM
    roteiro,
    categoria
WHERE
    roteiro.id_categoria = categoria.id";

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
                        <td class="linhasCentradasTabela"><?php echo $row_roteiros['nome']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_roteiros['data']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo ($row_roteiros['ativo']) ? 'Sim':'Não'; ?></td>
                        <td class="linhasCentradasTabela"><a href="index.php?area=editar_roteiro&id=<?php echo $row_roteiros['id']; ?>" class="editarRoteiro">Editar</a></td>
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

        $('#example').DataTable()
                .order([2, 'desc'])
                .draw();

    });


</script>