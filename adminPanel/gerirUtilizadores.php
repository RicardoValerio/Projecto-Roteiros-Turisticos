<?php
$sql = "SELECT
    utilizador.id,
    tipo_utilizador.tipo,
    utilizador.nome,
    utilizador.email,
    utilizador.ativo,
    utilizador.bloqueado
FROM
    utilizador,
    tipo_utilizador
WHERE
    utilizador.id_tipo_utilizador = tipo_utilizador.id;";

$result_utilizadores = mysql_query($sql);
?>

<body class="dt-example">
    <div class="container">

        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="sorting">Tipo de Utilizador</th>
                    <th class="sorting">Nome</th>
                    <th class="sorting">Email</th>
                    <th class="sorting">Ativo</th>
                    <th class="sorting">Bloqueado</th>
                    <th class="sorting">Editar</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Tipo de Utilizador</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ativo</th>
                    <th>Bloqueado</th>
                    <th>Editar</th>
                </tr>
            </tfoot>

            <tbody>

                <?php while ($row_utilizador = mysql_fetch_assoc($result_utilizadores)) { ?>
                    <tr>
                        <td class="linhasCentradasTabela"><?php echo $row_utilizador['tipo']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo utf8_encode($row_utilizador['nome']); ?></td>
                        <td class="linhasCentradasTabela"><?php echo $row_utilizador['email']; ?></td>
                        <td class="linhasCentradasTabela"><?php echo ($row_utilizador['ativo']) ? 'Sim' : 'Não'; ?></td>
                        <td class="linhasCentradasTabela"><?php echo ($row_utilizador['bloqueado']) ? 'Sim' : 'Não'; ?></td>
                        <td class="linhasCentradasTabela"><a href="index.php?area=editar_utilizador&id=<?php echo $row_utilizador['id']; ?>" class="editarRoteiro">Editar</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


    </div>
</body>

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