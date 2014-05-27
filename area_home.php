<div id="roteiros">
    <div id="introducao">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since type specimen book !!</p>
    </div>


    <?php
    $numBotoesPag = 3;
    $limit = 6;


    $sql_roteirosTodos = "SELECT  count(id) as total
			FROM
			    roteiro
                        WHERE ativo=1";
    $result_roteirosTodos = mysql_query($sql_roteirosTodos);
    $linhatotal = mysql_fetch_array($result_roteirosTodos);
    $total_num_rows = $linhatotal['total'];

    $totalPaginas = ceil($total_num_rows / $limit);


    $pag = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
    if($pag > $totalPaginas) $pag = $totalPaginas;

    $offset = (($pag - 1) * $limit);


    $sql_roteirosPag = "SELECT  id, titulo, imagem, descricao
			FROM
			    roteiro
                        WHERE ativo=1
			ORDER BY roteiro.data DESC limit $offset, $limit";

    $result_roteirosPag = mysql_query($sql_roteirosPag);

    if (@mysql_num_rows($result_roteirosPag)) {
        ?><div class="clearfix">
            <ul id="roteiroBox" class="clearfix"><?php
                while ($row = mysql_fetch_assoc($result_roteirosPag)) {
                    ?>
                    <li class="roteiro esq borda">

                        <div style="background-image: url('<?php echo 'img/gd_' . $row['imagem']; ?>');" class="ultimosRoteiros"></div>
                        <div class="descricao">
                            <h3><?php echo utf8_encode($row['titulo']); ?></h3>
                            <?php echo utf8_encode($row['descricao']); ?>
                        </div>
                        <div class="saibaMais">
                            <a href="index.php?area=destinos&roteiro=<?php echo $row['id']; ?>">Saiba mais</a>
                        </div>
                    </li>
                    <?php
                }
                ?></ul>
        </div>

        <div id="paginas" class="clearfix">
            <ul>
                <?php if ($pag >= $numBotoesPag) { ?>
                    <li><a href="?pag=1"><<</a></li>
                    <li><a href="?pag=<?php echo $pag - 1; ?>"><</a></li>
                    <li><a href="?pag=<?php echo (($pag - $numBotoesPag) < 1)  ? 1 : ($pag - $numBotoesPag);?>" class="reticencias">...</a></li>
                    <?php
                }

                if ($pag == 1) {
                    ?>
                    <li><a href="?pag=<?php echo $pag; ?>" class="paginaAtiva"><?php echo $pag; ?></a></li>
                    <?php if( ($pag + 1) <= $totalPaginas) { ?>
                    <li><a href="?pag=<?php echo $pag + 1; ?>"><?php echo $pag + 1; ?></a></li>
                    <?php } ?>
                    <?php if( ($pag + 2) <= $totalPaginas) { ?>
                    <li><a href="?pag=<?php echo $pag + 2; ?>"><?php echo $pag + 2; ?></a></li>
                    <?php } ?>

                <?php } else if ($pag > 1 && $pag < $totalPaginas) { ?>
                    <li><a href="?pag=<?php echo $pag - 1; ?>"><?php echo $pag - 1; ?></a></li>
                    <li><a href="?pag=<?php echo $pag; ?>" class="paginaAtiva"><?php echo $pag; ?></a></li>
                    <li><a href="?pag=<?php echo $pag + 1; ?>"><?php echo $pag + 1; ?></a></li>
                <?php } else if ($pag == $totalPaginas) { ?>
                    <?php if( ($pag - 2) >= 1) { ?>
                    <li><a href="?pag=<?php echo $pag - 2; ?>"><?php echo $pag - 2; ?></a></li>
                    <?php } ?>
                    <?php if( ($pag - 1) >= 1) { ?>
                    <li><a href="?pag=<?php echo $pag - 1; ?>"><?php echo $pag - 1; ?></a></li>
                    <?php } ?>
                    <li><a href="?pag=<?php echo $pag; ?>" class="paginaAtiva"><?php echo $pag; ?></a></li>
                    <?php
                }

                if ($pag <= ($totalPaginas - $numBotoesPag + 1)) {
                    ?>
                    <li><a href="?pag=<?php echo (($pag + $numBotoesPag) > $totalPaginas)  ? $totalPaginas : ($pag + $numBotoesPag); ?>" class="reticencias">...</a></li>
                    <li><a href="?pag=<?php echo $pag + 1 ?>">></a></li>
                    <li><a href="?pag=<?php echo $totalPaginas; ?>">>></a></li>
                <?php } ?>

            </ul>
        </div>

        <?php
    }
    ?>
</div>