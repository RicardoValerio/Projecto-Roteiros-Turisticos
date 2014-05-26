<div id="content" class="clearfix">
    <div id="sidebar" class="esq borda">
        <img src="img/sidebar_logo.png" />
        <div id="comentario">
            <div class="separador">
                <hr />
                <div>
                    <h2>Comentários</h2>
                </div>
            </div>
            <?php
            $get_parametro = htmlspecialchars(urlencode($_GET['categoria']));

            $sql_comentarios = "SELECT
		    comentario.comentario, comentario.data, nome 
		FROM
		    (comentario LEFT JOIN roteiro ON roteiro.id=id_roteiro) LEFT JOIN utilizador ON utilizador.id=comentario.id_utilizador
                WHERE
                    roteiro.id_categoria = $get_parametro
                    AND roteiro.ativo=1
		ORDER BY comentario.data DESC LIMIT 5";

            $result_comentarios = mysql_query($sql_comentarios);
            ?>
            <ul>
                <?php
                if (mysql_num_rows($result_comentarios)) {
                    while ($row = mysql_fetch_assoc($result_comentarios)) {
                        ?>
                        <li><p><?php echo utf8_encode($row['comentario']); ?></p><p><?php echo utf8_encode($row['nome']) . ', ' ?><span><?php echo date("d-m-Y", strtotime($row['data'])); ?></span></p></li>
                        <?php
                    }
                } else {
                    ?>
                    <p>Não existem comentários.</p>
                    <?php
                }
                ?>
            </ul>

        </div>
    </div>


    <?php
    $get_parametro = htmlspecialchars(urlencode($_GET['categoria']));

    $sql = 'SELECT * FROM roteiro
                WHERE roteiro.id_categoria = ' . $get_parametro . " AND roteiro.ativo = 1";

    $result = mysql_query($sql);
    ?>

    <?php if (mysql_num_rows($result)) { ?>
        <div class="mainContent dir borda">
            <?php while ($row = mysql_fetch_assoc($result)) { ?>
                <div class="listaRoteiro">
                    <a href="index.php?area=destinos&roteiro=<?php echo $row['id']; ?>">
                        <div>
                            <h2><?php echo $row['titulo']; ?></h2>
                        </div>
                        <div class="destinosDeCategoria" style="background-image: url('<?php echo $row['imagem']; ?>');" alt="<?php echo $row['titulo']; ?>">
                    </a>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <div class="mainContent">
            <p id="semRoteiro">Não existem roteiros para a categoria selecionada!</p>
        </div>
        <?php
    }
    ?>
</div>