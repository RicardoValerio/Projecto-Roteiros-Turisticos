<?php include '../includes/funcoes_imagens.php'; ?>

<h1 style="font-size: 3em;
    text-align: center;
    margin-top: 75px;
    ">Editar Categoria</h1>

<div style="margin-left: 69px;" id="editarRoteiro">

    <?php
    $id_get_parametro = mysql_real_escape_string($_GET['id']);

    $sql = "SELECT * FROM categoria WHERE id = $id_get_parametro";

    $result_categorias = mysql_query($sql);

    if (@mysql_num_rows($result_categorias)) {


        $row_categoria = mysql_fetch_assoc($result_categorias);
        ?>

        <form id="formEditarRoteiro" action="processaEditarCategoria.php" method="post" enctype="multipart/form-data">



            <h2> Categoria com Id # <?php echo $row_categoria['id']; ?></h2>
            <input type="hidden" name="i" value="<?php echo $row_categoria['id']; ?>">

            <hr>

            <p>
                <label for="categoria">Nome da Categoria:</label>
                <input type="text" name="nome_da_categoria" id="nome_da_categoria" value="<?php echo $row_categoria['nome']; ?>">
            </p>

            <hr>

            <p>
                <label for="imagem">Imagem:</label>
            <p>Hash da Imagem: <?php echo $row_categoria['imagem']; ?></p>
            <img src="<?php echo '../img/gd_' .$row_categoria['imagem']; ?>" alt="Imagem da Categoria.">
            <br>
            <input type="hidden" name="imagem_atual_categoria" value="<?php echo utf8_encode($row_categoria['imagem']); ?>">
            <input type="file" id="imagem" name="imagem" />
            </p>

            <hr>

            <input class="mySubmitButton" type="submit" value="Atualizar Roteiro" />

        </form>


        <?php
    } else {
        echo "Esse id não existe na BD";
    }
    ?>
</div>