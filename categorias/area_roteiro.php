<?php
//verificar se é um numero
//$get_parametro = (is_int($_GET['roteiro'])) $_GET['roteiro'] ? 0 ;
$get_parametro = htmlentities(urlencode($_GET['roteiro']));
$_SESSION['roteiro'] = $get_parametro;

if (!is_numeric($get_parametro)) {

    /*
     * DEVIAMOS METER O ULTIMO ROTEIRO ATIVO
     */
    echo '<p style="text-align:center">O roteiro escolhido não existe</p>';
    //@header("Location: index.php");
    exit;
}
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
		    comentario.comentario, comentario.data
		FROM
		    comentario
		WHERE
		    comentario.id_roteiro = $get_parametro
		ORDER BY comentario.data DESC
		LIMIT 3";


            $result_comentarios = mysql_query($sql_comentarios);
            ?>
            <ul>
                <?php
                if ($result_comentarios) {
                    while ($row = mysql_fetch_assoc($result_comentarios)) {
                        ?>
                        <li><?php echo $row['comentario']; ?><span><?php echo date("d-m-Y", strtotime($row['data'])); ?></span></li>
                        <?php
                    }
                }
                ?>
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

        <?php
        $sql_classificacao = "SELECT IFNULL(sum(classificacao),0) as classificacao FROM voto WHERE id_roteiro=$get_parametro";
        $sql_numVotos = "SELECT IFNULL(count(id),0) as numVotos FROM voto WHERE id_roteiro=$get_parametro";

        $resultado_classificacao = mysql_query($sql_classificacao);
        $resultado_numVotos = mysql_query($sql_numVotos);

        $row_classificacao = mysql_fetch_assoc($resultado_classificacao);
        $classificacao = $row_classificacao['classificacao'];

        $row_numVotos = mysql_fetch_assoc($resultado_numVotos);
        $numVotos = $row_numVotos['numVotos'];

        $media = ($numVotos == 0) ? 0 : $classificacao / $numVotos;

        if ($numVotos == 0) {
            $texto = '';
        } else if ($media <= 2) {
            $texto = VOTOS_BAIXO;
        } else if ($media >= 4) {
            $texto = VOTOS_ALTO;
        } else {
            $texto = VOTOS_MEDIO;
        }
        ?>

        <div id="votacao">
            <div class="separador">
                <hr />
                <div>
                    <h2>Votação</h2>
                </div>
            </div>
            <div id="estrelas">
                <ul class="clearfix">
                    <li class="estrelaVazia"></li>
                    <li class="estrelaVazia"></li>
                    <li class="estrelaVazia"></li>
                    <li class="estrelaVazia"></li>
                    <li class="estrelaVazia"></li>
                </ul>
            </div>
            <p><span id="classificacaoEstrelas"><?php echo number_format($media, 2, ",", '.'); ?></span> <span id="classificacaoTexto"><?php echo $texto; ?></span></p>
            <p><span id="numVotos"><?php echo number_format($numVotos, 0, ",", '.'); ?></span><span id="textoVotacoes"><?php echo ($numVotos==1) ? ' votação' : ' votações'; ?></span></p>
        </div>
    </div>

    <?php
    $sql_roteiro = "SELECT
            roteiro.titulo,
            roteiro.imagem,
            roteiro.sobre,
            roteiro.informacoes_uteis,
            roteiro.como_chegar,
            roteiro.descricao,
            regiao.nome AS 'regiao',
            categoria.nome AS 'categoria',
            utilizador.nome AS 'autor'
        FROM
            roteiro,
            regiao,
            categoria,
            utilizador
        WHERE
            roteiro.id = $get_parametro
                AND roteiro.id_categoria = categoria.id
                AND roteiro.id_regiao = regiao.id
                AND roteiro.id_utilizador = utilizador.id
                AND roteiro.ativo = 1";

    $result_roteiro = mysql_query($sql_roteiro);
    if ($result_roteiro) {
        while ($row = mysql_fetch_assoc($result_roteiro)) {
            ?>

            <div style="text-align: center;" id="detalheRoteiro" class="mainContent dir">
                <h1><?php echo utf8_decode($row['titulo']); ?></h1>
                <h2><?php echo $row['categoria']; ?></h2>
                <!-- <h2><?php echo $row['regiao']; ?></h2> -->
                <img src="<?php echo 'img/gd_' . $row['imagem']; ?>" />
                <p><?php echo utf8_decode($row['descricao']); ?></p>
                <div style="margin-top: 10px;" id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Sobre</a></li>
                        <li><a href="#tabs-2">Informações Úteis</a></li>
                        <li><a href="#tabs-3">Como Chegar</a></li>
                        <li><a href="#tabs-4">Galeria</a></li>
                        <li><a href="#tabs-5">Autor</a></li>
                    </ul>
                    <div id="tabs-1">
                        <p><?php echo utf8_decode($row['sobre']); ?></p>
                    </div>
                    <div id="tabs-2">
                        <p><?php echo utf8_decode($row['informacoes_uteis']); ?></p>
                    </div>
                    <div id="tabs-3">
                        <p><?php echo utf8_decode($row['como_chegar']); ?></p>
                    </div>
                    <div id="tabs-4">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum, qui, deleniti, provident, repellendus officiis corrupti nisi unde laudantium delectus dolorem dignissimos assumenda voluptas optio illo quasi voluptates iure fugiat distinctio.</p>
                    </div>
                    <div id="tabs-5">
                        <p><?php echo utf8_decode($row['autor']); ?></p>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <script>
            $(function() {
                $("#tabs").tabs();
            });
        </script>
    </div>

</div>