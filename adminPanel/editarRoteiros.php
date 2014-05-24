<h1 style="font-size: 3em;
color:#D3109F;
text-align: center;
margin-top: 75px;
">Editar Roteiro</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <!-- <h1><span id="normal">Inserir</span> Roteiro</h1> -->

    <?php

    $id_get_parametro = mysql_real_escape_string($_GET['id']);

    $sql = "SELECT * FROM roteiro WHERE id = $id_get_parametro";

    $result_roteiros = mysql_query($sql);

    ?>

<?php if (@mysql_num_rows($result_roteiros)): ?>


    <?php $roteiros_array = mysql_fetch_assoc($result_roteiros); ?>

    <form id="formEditarRoteiro" action="processaEditarRoteiro.php" method="post" enctype="multipart/form-data">



    <h2> Roteiro com Id # <?php echo $roteiros_array['id']; ?> </h2>



    <?php

    $sql = "SELECT * FROM utilizador WHERE id = " . $roteiros_array['id_utilizador'];
    $row_utilizador = mysql_fetch_assoc(mysql_query($sql));

     ?>

        <p>
            <label for="utilizador">Utilizador:</label>
            <h5><?php echo $row_utilizador['nome'];  ?></h5>
            <h5><?php echo $row_utilizador['email'];  ?></h5>
        </p>

        <p>
            <label for="nome">Nome/Título do Roteiro:</label>
            <input type="text" id="nome" name="titulo" value="<?php echo $roteiros_array['titulo']; ?>" />
        </p>

        <p>
            <label for="regiao">Região:</label>

            <?php
            $sql = "SELECT * FROM nuts";
            $result_nuts = mysql_query($sql);
            ?>

            <select id="regiao" name="regiao">
            <?php while ($row_nuts = @mysql_fetch_assoc($result_nuts)): ?>

                <optgroup label="<?php echo utf8_encode($row_nuts['nome']); ?>">

                    <?php
                    $sql = "SELECT * FROM regiao WHERE regiao.id_nuts = " . $row_nuts['id'];
                    $result_regiao = mysql_query($sql);
                    ?>
                    <?php while ($row_regiao = mysql_fetch_assoc($result_regiao)): ?>

                    <option value="<?php echo $row_regiao['id']; ?>" <?php if ( $row_regiao['id'] == $roteiros_array['id_regiao']) echo "selected"; ?> ><?php echo utf8_encode($row_regiao['nome']); ?></option>

                   <?php endwhile; ?>

            <?php endwhile; ?>
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

            <option value="<?php echo $row_cat['id']; ?>"
                           <?php if($row_cat['id'] == $roteiros_array['id_categoria']) echo "selected"; ?> >
                <?php echo utf8_encode($row_cat['nome']); ?>
            </option>

            <?php endwhile; ?>
    </select>

</p>


<p>
    <label for="imagem">Imagem:</label>
    <input type="text" name="nome_imagem" id="nome_imagem" value="<?php echo $roteiros_array['imagem']; ?>">
    <input type="file" id="imagem" name="imagem" />
</p>


<!--    <p>
                <label for="tempo" >Tempo:</label>
                <input type="text" id="tempo" name="tempo" />
        </p>
    -->

    <!-- TODO: fazer um ciclo e colocar o id dentro dos indices dos arrays do percurso bem como os values e id-->

<?php
    $sql_roteiro_tem_percursos = "SELECT * FROM roteiro_tem_tipo WHERE id_roteiro = " . $roteiros_array['id'];

    $array_ids_percursos_do_roteiro = array();
?>

<?php if ($result_roteiro_tem_percurso = mysql_query($sql_roteiro_tem_percursos)): ?>
        <?php while($row_roteiro_tem_percurso = mysql_fetch_assoc($result_roteiro_tem_percurso)): ?>
            <?php  $array_ids_percursos_do_roteiro[] = $row_roteiro_tem_percurso['id_tipo']; ?>
        <?php endwhile; ?>
<?php endif ?>


<?php
    $sql_percursos = "SELECT * FROM tipo";
    $result_percursos = mysql_query($sql_percursos);
 ?>

    <fieldset>
        <legend>Percursos nas Imediações:</legend>
        <p>
            <?php while ($row_percurso = @mysql_fetch_assoc($result_percursos)): ?>
            <label for="<?php echo utf8_encode($row_percurso['tipo']); ?>"><?php echo utf8_encode($row_percurso['tipo']); ?></label><input type="checkbox" name="percurso[<?php echo $row_percurso['id']; ?>]" id="<?php echo utf8_encode($row_percurso['id']); ?>" value="<?php echo utf8_encode($row_percurso['tipo']); ?>"
            <?php if(in_array($row_percurso['id'], $array_ids_percursos_do_roteiro)) echo "checked";?>>
        <?php endwhile; ?>
        </p>
    </fieldset>



    <p>
        <label for="descricao">Descrição:</label>
        <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="descricao" id="descricao" placeholder="Insira uma breve descrição sobre o roteiro...">
            <?php echo $roteiros_array['descricao']; ?>
        </textarea>
    </p>

    <p>
        <label for="como_chegar">Como Chegar:</label>
        <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="como_chegar" id="como_chegar" placeholder="Insira uma breve indicação de como chegar ao local...">
            <?php echo $roteiros_array['como_chegar']; ?>
        </textarea>
    </p>

    <p>
        <label for="sobre">Sobre:</label>
        <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="sobre" id="sobre" placeholder="Insira uma descrição mais detalhada sobre o roteiro...">
            <?php echo $roteiros_array['sobre']; ?>
        </textarea>
    </p>

    <p>
        <label for="infos_uteis">Informações Úteis:</label>
        <textarea style="margin: 2px; height: 157px; width: 843px; resize: none;" name="infos_uteis" id="infos_uteis" placeholder="Insira um conjunto de informações úteis sobre o roteiro...">
            <?php echo $roteiros_array['informacoes_uteis']; ?>
        </textarea>
    </p>


<?php
    $sql_roteiro_tem_palavras = "SELECT * FROM palavra_chave WHERE id_roteiro = " . $roteiros_array['id'];

    $palavras_do_roteiro = array();
 ?>
<?php if ($result_roteiro_tem_palavras = mysql_query($sql_roteiro_tem_palavras)): ?>
        <?php while($row_roteiro_tem_palavras = mysql_fetch_assoc($result_roteiro_tem_palavras)): ?>
            <?php  $palavras_do_roteiro[] = $row_roteiro_tem_palavras['palavra']; ?>
        <?php endwhile; ?>
<?php endif ?>

<?php $string_palavras_do_roteiro = implode(",", $palavras_do_roteiro); ?>

    <p>
        <label>Palavras-Chave:</label>
        <input style="width: 300px;" id="palavras_chave" name="palavras_chave" type="text" class="tags" value="<?php echo $string_palavras_do_roteiro; ?>" />
    </p>

    <input type="submit" value="Inserir Roteiro" />

</form>

<script>
$(function() {
    $('#palavras_chave').tagsInput({width: 'auto'});
});

</script>

<script>
CKEDITOR.replace('descricao');
CKEDITOR.replace('como_chegar');
CKEDITOR.replace('sobre');
CKEDITOR.replace('infos_uteis');
</script>

</div>


<?php else: ?>
    <?php echo "Bazinga!, Esse id não existe na BD"; ?>
<?php endif ?>