<?php
$get_parametro = mysql_real_escape_string(urlencode($_GET['roteiro']));

$sql_verificaId = "SELECT id
        FROM
            roteiro
        WHERE
            id = $get_parametro AND roteiro.ativo = 1";

$result_verificaId = mysql_query($sql_verificaId);

if (!mysql_num_rows($result_verificaId)) {
    $sql_verificaId = "SELECT id
        FROM
            roteiro
        WHERE
            roteiro.ativo = 1
        ORDER BY data DESC";

    $result_verificaId = mysql_query($sql_verificaId);

    if (mysql_num_rows($result_verificaId)) {
        $linha = mysql_fetch_assoc($result_verificaId);

        $url = 'index.php?area=destinos&roteiro=' . $linha['id'];
        header("Location: $url");
        exit();
    } else {
        header('Location: index.php?area=destinos');
        exit();
    }
}

$_SESSION['roteiro'] = $get_parametro;
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
            <form id = "formComentar" <?php if (isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"])) echo 'action="inserirComentario.php"'; ?> method = "post" <?php if (!(isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"]))) echo 'disabled'; ?>>
                <textarea id = "comentar" name = "comentar" maxlength="50" placeholder="<?php echo (isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"])) ? 'Insira o seu comentário...' : 'Para comentar faça login ou registe-se.'; ?>" <?php if (!(isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"]))) echo 'disabled'; ?> ></textarea>
                <input type = "submit" value = "Comentar" <?php if (!(isset($_SESSION["nome"]) && isset($_SESSION["tipo_utilizador"]))) echo 'disabled'; ?> />
            </form>
            <?php
            $sql_comentarios = "SELECT
		    comentario.comentario, comentario.data, nome 
		FROM
		    comentario LEFT JOIN utilizador ON utilizador.id=id_utilizador
		WHERE
		    comentario.id_roteiro = $get_parametro
		ORDER BY comentario.data DESC
		LIMIT 3";


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

            <?php
            $sql_palavrasChave = "SELECT palavra FROM palavra_chave WHERE id_roteiro = $get_parametro";
            $resultado_palavrasChave = mysql_query($sql_palavrasChave);

            if (mysql_num_rows($resultado_palavrasChave)) {
                ?><ul class="clearfix"><?php
                while ($row = mysql_fetch_assoc($resultado_palavrasChave)) {
                    ?><li class="borda"><a href="index.php?area=o_que_procura&pesquisa=<?php echo urlencode(utf8_encode($row['palavra'])); ?>"><?php echo utf8_encode($row['palavra']); ?></a></li><?php
                    }
                    ?></ul><?php
                } else {
                    ?><p>Não existem palavras chave para este roteiro.</p><?php
                }
                ?>

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
                    <li title="1" class="estrelaVazia"></li>
                    <li title="2" class="estrelaVazia"></li>
                    <li title="3" class="estrelaVazia"></li>
                    <li title="4" class="estrelaVazia"></li>
                    <li title="5" class="estrelaVazia"></li>
                </ul>
            </div>
            <p><span id="classificacaoEstrelas"><?php echo number_format($media, 2, ",", '.'); ?></span> <span id="classificacaoTexto"><?php echo $texto; ?></span></p>
            <p><span id="numVotos"><?php echo number_format($numVotos, 0, ",", '.'); ?></span><span id="textoVotacoes"><?php echo ($numVotos == 1) ? ' votação' : ' votações'; ?></span></p>
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
            roteiro.data,
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
                <h1><?php echo utf8_encode($row['titulo']); ?></h1>
                <h2><?php echo utf8_encode($row['categoria']); ?></h2>
                <img src="<?php echo 'img/gd_' . $row['imagem']; ?>" />
                <div id="descricaoDetalheRoteiro"><?php echo utf8_encode($row['descricao']); ?></div>
                <ul id="imagensTipoTransporte">
                    <?php
                    $sql = "SELECT * FROM tipo INNER JOIN roteiro_tem_tipo on id=id_tipo WHERE id_roteiro=$get_parametro";
                    $result = mysql_query($sql);
                    while ($linha = mysql_fetch_assoc($result)) {
                        ?>
                        <li>
                            <img src="<?php echo 'img/' . $linha['imagem']; ?>" alt="<?php echo utf8_encode($linha['tipo']) ?>" title="<?php echo utf8_encode($linha['tipo']) ?>" />
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <div style="margin-top: 10px;" id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Sobre</a></li>
                        <li><a href="#tabs-2">Informações Úteis</a></li>
                        <li><a href="#tabs-3">Como Chegar</a></li>
                        <li><a href="#tabs-4">Região</a></li>
                        <li><a href="#tabs-5">Data</a></li>
                        <li><a href="#tabs-6">Autor</a></li>
                    </ul>
                    <div id="tabs-1">
                        <p><?php echo utf8_encode($row['sobre']); ?></p>
                    </div>
                    <div id="tabs-2">
                        <p><?php echo utf8_encode($row['informacoes_uteis']); ?></p>
                    </div>
                    <div id="tabs-3">
                        <p><?php echo utf8_encode($row['como_chegar']); ?></p>
                    </div>
                    <div id="tabs-4">
                        <p><?php echo utf8_encode($row['regiao']); ?></p>
                    </div>
                    <div id="tabs-5">
                        <p><?php echo date("d-m-Y H:i:s", strtotime($row['data'])); ?></p>
                    </div>
                    <div id="tabs-6">
                        <p><?php echo utf8_encode($row['autor']); ?></p>
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