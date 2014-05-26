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
            $sql_comentarios = "SELECT
		    comentario.comentario, comentario.data, nome 
		FROM
		    (comentario LEFT JOIN roteiro ON roteiro.id=id_roteiro) LEFT JOIN utilizador ON utilizador.id=comentario.id_utilizador
                WHERE
                    roteiro.ativo=1
		ORDER BY comentario.data DESC LIMIT 5";

            $result_comentarios = mysql_query($sql_comentarios);
            ?>
            <ul>
                <?php
                if (mysql_num_rows($result_comentarios)) {
                    while ($row = mysql_fetch_assoc($result_comentarios)) {
                        ?>
                        <li><div><?php echo utf8_encode($row['comentario']); ?></div><p><?php echo utf8_encode($row['nome']) . ', ' ?><span><?php echo date("d-m-Y", strtotime($row['data'])); ?></span></p></li>
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
        <!-- <div id="facebook">
                <div class="separador">
                        <hr />
                        <div>
                                <h2>Facebook</h2>
                        </div>
                </div>
                <p><span>Lorem ipsum dolor sit amet, </span>consectetur adipiscing elittiam et nisi nec elit scelerisque suscipit.</p>
        </div> -->
    </div>
    <div class="mainContent dir borda">

        <?php
        $sql_categorias = 'SELECT * FROM categoria';
        $result_categorias = mysql_query($sql_categorias);
        ?>

        <?php if ($result_categorias) { ?>
            <?php while ($row = mysql_fetch_assoc($result_categorias)) { ?>
                <div class="listaRoteiro">
                    <a href="index.php?area=destinos&categoria=<?php echo $row['id']; ?>">
                        <div>
                            <h2><?php echo utf8_encode($row['nome']); ?></h2>
                        </div>
                            <img src="img/<?php echo $row['imagem']; ?>" alt="<?php echo utf8_encode($row['nome']); ?>"/>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>

    </div>
</div>