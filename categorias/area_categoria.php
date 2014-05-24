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

            $sql = "SELECT  comentario.comentario,
			    comentario.data
			FROM
			    comentario,
			    roteiro
			WHERE
			    roteiro.id_categoria = $get_parametro
			        AND roteiro.id = comentario.id_roteiro
			ORDER BY roteiro.id DESC
			LIMIT 3";


            $result = mysql_query($sql);
            ?>
            <ul>
                <?php while ($row = @mysql_fetch_assoc($result)) { ?>
                    <li><?php echo $row['comentario']; ?><span><?php echo date("d-m-Y", strtotime($row['data'])); ?></span></li>
                <?php } ?>
            </ul>
        </div>
        <div id="palavrasChave">
            <div class="separador">
                <hr />
                <div>
                    <h2>Palavras chave</h2>
                </div>
            </div>
            <ul class="clearfix">
                <li class="borda">Lorem</li>
                <li class="borda">Consectetur</li>
                <li class="borda">Etiam</li>
                <li class="borda">Themeforest</li>
                <li class="borda">Sagittis</li>
                <li class="borda">Vestibunolum</li>
                <li class="borda">Curabitur</li>
            </ul>
        </div>
    </div>
    <div class="mainContent dir borda">

        <?php
        $get_parametro = htmlspecialchars(urlencode($_GET['categoria']));

        $sql = 'SELECT * FROM roteiro WHERE id_categoria = ' . $get_parametro;

        $result = mysql_query($sql);
        ?>

        <?php if (@mysql_num_rows($result)) { ?>

            <?php while ($row = mysql_fetch_assoc($result)) { ?>
                <div class="listaRoteiro">
                    <a href="index.php?area=destinos&roteiro=<?php echo $row['id']; ?>">
                        <div>
                            <h2><?php echo $row['titulo']; ?></h2>
                        </div>
                        <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['titulo']; ?>"/>
                    </a>
                </div>
            <?php }

            } else {

            $sql = "SELECT * FROM roteiro
					   WHERE id_categoria = ( SELECT roteiro.id FROM roteiro
					   						  ORDER BY roteiro.id
					   						  LIMIT 1)";

            $result = mysql_query($sql);
            ?>
            <?php if ($result) { ?>
                <?php while ($row = mysql_fetch_assoc($result)) { ?>
                    <div class="listaRoteiro">
                        <a href="index.php?area=destinos&roteiro=<?php echo $row['id']; ?>">
                            <div>
                                <h2><?php echo $row['titulo']; ?></h2>
                            </div>
                            <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['titulo']; ?>"/>
                        </a>
                    </div>
                <?php } ?>
            <?php } ?>

        <?php } ?>

    </div>
</div>