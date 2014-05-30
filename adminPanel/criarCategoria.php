    <h1 style="font-size: 3em;
        text-align: center;
        margin-top: 75px;
        ">Criar Categoria</h1>


    <form id="formCriarCategoria" action="processaCriarCategoria.php" method="post" enctype="multipart/form-data">

        <p>
            <label for="nome">Nome da Nova Categoria:</label>
            <input type="text" id="nome" name="nome_da_nova_categoria" />
        </p>

        <p id="imagem">
            <label for="imagem">Imagem da Nova Categoria:</label>
            <input type="file" id="imagem" name="imagem" />
        </p>


        <input class="mySubmitButton" type="submit" value="Criar Categoria" />

    </form>

</div>