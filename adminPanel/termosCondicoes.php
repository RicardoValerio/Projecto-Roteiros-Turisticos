<h1 style="font-size: 3em;
text-align: center;
margin-top: 75px;
">Editar Termos & Condições</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <?php


    $sql = "SELECT * FROM texto";

    $result_termos = mysql_query($sql);

    ?>

    <?php if (@mysql_num_rows($result_termos)): ?>


    <?php $row_termos = mysql_fetch_assoc($result_termos); ?>

    <form id="formEditarTermos" action="processaEditarTermosCondicoes.php" method="post">


        <input type="hidden" name="i" value="<?php echo $row_termos['id']; ?>">

        <p>
            <label for="termos">Termos e Condições:</label>
            <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="termos" id="termos" placeholder="Insira uma breve descrição sobre o roteiro...">
                <?php echo $row_termos['texto']; ?>
            </textarea>
        </p>

        <input class="mySubmitButton" type="submit" value="Atualizar Termos e Condições" />

    </form>

    </script>

    <script>
    CKEDITOR.replace('termos');
    </script>

</div>


<?php else: ?>
    <?php echo "Não existe nada nessta tabela!"; ?>
<?php endif ?>
