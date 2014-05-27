<?php
require_once 'verificaSession.php';

if ($_SESSION["tipo_utilizador"] == 'admin') {
    ?>
    <h1 style="font-size: 3em;
        text-align: center;
        margin-top: 75px;
        ">Inserir Roteiro</h1>
    <?php } ?>
<div style="<?php if ($_SESSION["tipo_utilizador"] == 'admin') echo 'margin-left: 69px;' ?>" id="inserirRoteiro">
    <?php
    if ($_SESSION["tipo_utilizador"] != 'admin') {
        ?>
        <h1><span id="normal">Inserir</span> Roteiro</h1>
    <?php } ?>

    <form class="<?php if ($_SESSION["tipo_utilizador"] != 'admin') echo 'inserirRoteiros' ?>" id="formInserirRoteiro" action="<?php echo ($_SESSION['tipo_utilizador'] == 'admin') ? '../processaInserirRoteiro.php' : 'processaInserirRoteiro.php'; ?>" method="post" enctype="multipart/form-data">

        <p>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="titulo" />
        </p>

        <p>
            <label for="regiao">Região:</label>

            <?php
            $sql = "SELECT * FROM nuts";
            $result_nuts = mysql_query($sql);
            ?>

            <select id="regiao" name="regiao">
                <?php while ($row_nuts = @mysql_fetch_assoc($result_nuts)) { ?>

                    <optgroup label="<?php echo utf8_encode($row_nuts['nome']); ?>">

                        <?php
                        $sql = "SELECT * FROM regiao WHERE regiao.id_nuts = " . $row_nuts['id'];
                        $result_regiao = mysql_query($sql);
                        ?>
                        <?php while ($row_regiao = mysql_fetch_assoc($result_regiao)) { ?>

                            <option value="<?php echo $row_regiao['id']; ?>"><?php echo utf8_encode($row_regiao['nome']); ?></option>

                        <?php } ?>

                    <?php } ?>
            </select>

        </p>


        <p>
            <label for="categoria">Categoria:</label>

            <?php
            $sql = "SELECT * FROM categoria";
            $result_cat = mysql_query($sql);
            ?>

            <select id="categoria" name="categoria">
                <?php while ($row_cat = @mysql_fetch_assoc($result_cat)): ?>

                    <option value="<?php echo $row_cat['id']; ?>"><?php echo utf8_encode($row_cat['nome']); ?></option>

                <?php endwhile; ?>
            </select>

        </p>


        <p id="imagem">
            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem" />
        </p>


<!-- 	<p>
                <label for="tempo" >Tempo:</label>
                <input type="text" id="tempo" name="tempo" />
        </p>
        -->

        <!-- TODO: fazer um ciclo e colocar o id dentro dos indices dos arrays do percurso bem como os values e id-->

        <?php
        $sql_percursos = "SELECT * FROM tipo";
        $result_percursos = mysql_query($sql_percursos);
        ?>

        <fieldset>
            <legend>Percursos nas Imediações:</legend>
            <p>
                <?php while ($row_percurso = @mysql_fetch_assoc($result_percursos)) { ?>
                    <label class="labelTransp" for="<?php echo utf8_encode($row_percurso['tipo']); ?>">
                        <?php echo utf8_encode($row_percurso['tipo']); ?>
                        <input type="checkbox" name="percurso[<?php echo $row_percurso['id']; ?>]" id="<?php echo utf8_encode($row_percurso['tipo']); ?>" value="<?php echo utf8_encode($row_percurso['tipo']); ?>">
                    </label>
                <?php } ?>
            </p>
        </fieldset>

        <div class="areas">
            <p>
                <label for="descricao">Descrição:</label>
                <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="descricao" id="descricao">
                </textarea>
            </p>

            <p>
                <label for="como_chegar">Como Chegar:</label>
                <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="como_chegar" id="como_chegar">
                </textarea>
            </p>

            <p>
                <label for="sobre">Sobre:</label>
                <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="sobre" id="sobre">
                </textarea>
            </p>

            <p>
                <label for="infos_uteis">Informações Úteis:</label>
                <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="infos_uteis" id="infos_uteis">
                </textarea>
            </p>


            <p>
                <label>Palavras-Chave:</label>
                <input id="palavras_chave" name="palavras_chave" type="text" class="tags" value="" />
            </p>
        </div>

        <input type="submit" value="Inserir Roteiro" />

    </form>

</div>

<script type="text/javascript" src="<?php echo ($_SESSION['tipo_utilizador'] == 'admin') ? '../js/plugin.tags.js' : 'js/plugin.tags.js'; ?>"></script>
<script>
    $(document).ready(function() {
        CKEDITOR.replace('descricao');
        CKEDITOR.replace('como_chegar');
        CKEDITOR.replace('sobre');
        CKEDITOR.replace('infos_uteis');

        $(function() {
            $('#palavras_chave').tagsInput({width: 'auto'});
        });
    });
</script>