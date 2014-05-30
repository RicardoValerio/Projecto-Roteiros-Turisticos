
<body class="dt-example">
    <div class="container">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="sorting">Nome da Categoria</th>
                    <th class="sorting">Nº de Roteiros</th>
                    <th class="sorting">Editar Categoria</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Nome da Categoria</th>
                    <th>Nº de Roteiros</th>
                    <th>Editar Categoria</th>
                </tr>
            </tfoot>

            <tbody>

                <?php
                $sql = "SELECT
                            categoria.id,
                            categoria.nome
                        FROM
                            categoria";

                $result_categorias = mysql_query($sql);
                ?>

                <?php while ($row_categoria = mysql_fetch_assoc($result_categorias)) { ?>
                    <?php

                        $sql_count = "SELECT COUNT(*)
                                      FROM roteiro
                                      WHERE roteiro.id_categoria = " . $row_categoria['id'];

                        $result_count_roteiros_das_categorias = @mysql_query($sql_count);
                        $row_count = mysql_fetch_row($result_count_roteiros_das_categorias);
                    ?>
                    <tr>
                        <td class="linhasCentradasTabela"><?php echo utf8_encode($row_categoria['nome']); ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_count[0]; ?></td>
                        <td class="linhasCentradasTabela"><a href="index.php?area=editar_categoria&id=<?php echo $row_categoria['id']; ?>" class="editarRoteiro">Editar</a></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</body>

<script type="text/javascript" language="javascript" class="init">

    $(document).ready(function() {
        $('#example').dataTable();

        // tive de adicionar isto pois foi a unica forma de conseguir com que a tabela
        // fica-se ordenada pela data de forma descendente - pelo sql não deu, deve ser
        $('#example').DataTable()
                .order([0, 'asc'])
                .draw();
    });


</script>


