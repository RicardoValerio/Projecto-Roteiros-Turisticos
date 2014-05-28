<h1 style="font-size: 3em;
    text-align: center;
    margin-top: 75px;
    ">Editar Utilizador</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <?php
    $id_get_parametro = mysql_real_escape_string($_GET['id']);

    $sql = "SELECT
            utilizador.id,
            tipo_utilizador.tipo,
            utilizador.nome,
            utilizador.email,
            utilizador.ativo
        FROM
            utilizador,
            tipo_utilizador
        WHERE
            utilizador.id = $id_get_parametro
        AND utilizador.id_tipo_utilizador = tipo_utilizador.id";

    $result_utilizadores = mysql_query($sql);

    if (@mysql_num_rows($result_utilizadores)) {

        $row_utilizador = mysql_fetch_assoc($result_utilizadores);
        ?>

        <form id="formEditarUtilizador" action="processaEditarUtilizador.php" method="post">

            <h2> Utilizador com Id # <?php echo $row_utilizador['id']; ?></h2>
            <input type="hidden" name="i" value="<?php echo $row_utilizador['id']; ?>">
            <hr>

            <?php
            $sql_tipos = "SELECT * FROM tipo_utilizador";
            $result_tipos = mysql_query($sql_tipos);
            ?>

            <p>
                <label for="tipo_utilizador">Tipo de Utilizador:</label>
                <select name="tipo_utilizador" id="utilizador">
                    <?php while ($row_tipos = mysql_fetch_assoc($result_tipos)) { ?>

                        <option value="<?php echo $row_tipos['id']; ?>" <?php if ($row_tipos['tipo'] == $row_utilizador['tipo']) echo "selected"; ?>>
                            <?php echo $row_tipos['tipo']; ?></option>
                    <?php } ?>
                </select>
            </p>
            <hr>
            <p>
                <label for="nome_utilizador">Nome do Utilizador:</label>
                <input type="text" name="nome_utilizador" id="nome_utilizador" value="<?php echo utf8_encode($row_utilizador['nome']); ?>">
            </p>
            <hr>
            <p>
                <label for="email_utilizador">Email do Utilizador:</label>
                <input type="text" name="email_utilizador" id="email_utilizador" value="<?php echo $row_utilizador['email']; ?>">
            </p>
            <hr>

            <input class="mySubmitButton" type="submit" value="Atualizar Utilizador" />

        </form>

    </div>

    <?php
}
?>

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#formEditarUtilizador').bind('submit', function(event) {
                var formData = new FormData($(this)[0]);
                
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'processaEditarUtilizador.php',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        dialogMessageNormal('#dialog_mensage', 'Editar utilizador');
                        $('#dialog_text').html(response.mensagem);
                    }
                });
            });
        });
    });
</script>