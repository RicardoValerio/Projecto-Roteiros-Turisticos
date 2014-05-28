<h1 style="font-size: 3em;
    text-align: center;
    margin-top: 75px;
    ">Editar Termos & Condições</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <?php
    $local = "termos_condicoes";

    $sql = "SELECT * FROM texto WHERE local = '$local'";

    $result_termos = mysql_query($sql);
    ?>
    <form id="formEditarTermos" action="processaEditarTermosCondicoes.php" method="post">
        <p>
            <label for="termos">Termos e Condições:</label>
            <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="termos" id="termos">
                <?php
                if (@mysql_num_rows($result_termos)) {
                    $row_termos = mysql_fetch_assoc($result_termos);
                    echo utf8_encode($row_termos['texto']);
                }
                ?>
            </textarea>
        </p>

        <input class="mySubmitButton" type="submit" value="Atualizar Termos e Condições" />

    </form>
    <?php ?>
</div>

<script>
    CKEDITOR.replace('termos');

    $(document).ready(function() {
        $(document).ready(function() {
            $('#formEditarTermos').bind('submit', function(event) {
                var formData = new FormData($(this)[0]);
                formData.append('termos', CKEDITOR.instances['termos'].getData());

                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'processaEditarTermosCondicoes.php',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        dialogMessageNormal('#dialog_mensage', 'Editar termos e condições');
                        $('#dialog_text').html(response.mensagem);
                    }
                });
            });
        });
    });
</script>