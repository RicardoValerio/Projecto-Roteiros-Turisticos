<?php
$get_parametro = mysql_real_escape_string(urlencode($_GET['categoria']));

/* verifica categoria */
/* se nao existir meter categoria a 1 */

/* se nao existirem categorias meter pag em branco a dizer q nao existem categorias */

//exit();
?>



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

    <a name="roteiros"></a>
    <div id="rightContent" class="dir">
        <?php
        $numBotoesPag = 3;
        $limitRoteiros = 9;

        $sql_roteirosTodos = "SELECT  count(id) as total
			FROM
			    roteiro
                        WHERE roteiro.id_categoria = $get_parametro AND roteiro.ativo = 1";

        $result_roteirosTodos = mysql_query($sql_roteirosTodos);
        $linhatotal = mysql_fetch_array($result_roteirosTodos);
        $total_num_rows = $linhatotal['total'];

        $totalPaginas = ceil($total_num_rows / $limitRoteiros);

        $pag = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
        if ($pag > $totalPaginas)
            $pag = $totalPaginas;

        $offsetRoteiros = (($pag - 1) * $limitRoteiros);

        $sql_roteirosPag = "SELECT  roteiro.id, titulo, imagem, descricao, regiao.nome as regiao
			FROM
			    roteiro left join regiao on id_regiao=regiao.id
                        WHERE roteiro.id_categoria=$get_parametro AND roteiro.ativo=1
			ORDER BY roteiro.data DESC limit $offsetRoteiros, $limitRoteiros";
        
        $result_roteirosPag = mysql_query($sql_roteirosPag);

        if (@mysql_num_rows($result_roteirosPag)) {
            ?>
            <ul class="mainContent dir">
                <?php while ($row = mysql_fetch_assoc($result_roteirosPag)) { ?>
                    <li class="listaRoteiro">
                        <a href="index.php?area=destinos&roteiro=<?php echo $row['id']; ?>">
                            <div>
                                <h2><?php echo utf8_encode($row['titulo']); ?></h2>
                                <h3><?php echo utf8_encode($row['regiao']); ?></h3>
                            </div>
                            <div class="destinosDeCategoria" style="background-image: url('<?php echo 'img/pq_' . $row['imagem']; ?>');" alt="<?php echo utf8_encode($row['titulo']); ?>">
                            </div>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div id="paginas" class="clearfix">
                <ul>
                    <?php if ($pag >= $numBotoesPag) { ?>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=$get_parametro&pag=1#roteiros'; ?>"><<</a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag - 1); ?>#roteiros"><</a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . (($pag - $numBotoesPag) < 1) ? 1 : ($pag - $numBotoesPag); ?>#roteiros" class="reticencias">...</a></li>
                        <?php
                    }

                    if ($pag == 1) {
                        ?>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . $pag; ?>#roteiros" class="paginaAtiva"><?php echo $pag; ?></a></li>
                        <?php if (($pag + 1) <= $totalPaginas) { ?>
                            <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag + 1); ?>#roteiros"><?php echo $pag + 1; ?></a></li>
                        <?php } ?>
                        <?php if (($pag + 2) <= $totalPaginas) { ?>
                            <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag + 2); ?>#roteiros"><?php echo $pag + 2; ?></a></li>
                        <?php } ?>

                    <?php } else if ($pag > 1 && $pag < $totalPaginas) { ?>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag - 1); ?>#roteiros"><?php echo $pag - 1; ?></a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . $pag; ?>#roteiros" class="paginaAtiva"><?php echo $pag; ?></a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag + 1); ?>#roteiros"><?php echo $pag + 1; ?></a></li>
                    <?php } else if ($pag == $totalPaginas) { ?>
                        <?php if (($pag - 2) >= 1) { ?>
                            <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag - 2); ?>#roteiros"><?php echo $pag - 2; ?></a></li>
                        <?php } ?>
                        <?php if (($pag - 1) >= 1) { ?>
                            <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag - 1); ?>#roteiros"><?php echo $pag - 1; ?></a></li>
                        <?php } ?>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . $pag; ?>#roteiros" class="paginaAtiva"><?php echo $pag; ?></a></li>
                        <?php
                    }

                    if ($pag <= ($totalPaginas - $numBotoesPag + 1)) {
                        ?>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . (($pag + $numBotoesPag) > $totalPaginas) ? $totalPaginas : ($pag + $numBotoesPag); ?>#roteiros" class="reticencias">...</a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . ($pag + 1) ?>#roteiros">></a></li>
                        <li><a href="<?php echo 'index.php?area=destinos&categoria=' . $get_parametro . '&pag=' . $totalPaginas; ?>#roteiros">>></a></li>
                    <?php } ?>

                </ul>
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
</div>