<?php

/* * *******
 *  VERIFICAÇÃO DE DADOS
 * ******* */

if (!strlen(trim($_POST['titulo'])) || !isset($_POST['percurso']) || !strlen(trim($_POST['descricao'])) || !strlen(trim($_POST['sobre'])) || !strlen(trim($_POST['infos_uteis'])) || !strlen(trim($_POST['como_chegar'])) || !strlen(trim($_POST['palavras_chave']))) {
    $arrayMensagem = array();

    if (!strlen(trim($_POST['titulo'])))
        array_push($arrayMensagem, "Insira o título do roteiro.");
    if (!isset($_POST['percurso']))
        array_push($arrayMensagem, "Insira as formas de percursos.");
    if (!strlen(trim($_POST['descricao'])))
        array_push($arrayMensagem, "Insira a descrição do roteiro.");
    if (!strlen(trim($_POST['sobre'])))
        array_push($arrayMensagem, "Insira informação sobre o roteiro.");
    if (!strlen(trim($_POST['infos_uteis'])))
        array_push($arrayMensagem, "Insira as informações úteis do roteiro.");
    if (!strlen(trim($_POST['como_chegar'])))
        array_push($arrayMensagem, "Insira a forma de chegar ao local do roteiro.");
    if (!strlen(trim($_POST['palavras_chave'])))
        array_push($arrayMensagem, "Insira as palavras-chave do roteiro.");

    $mensagem = implode("<br/><br/>", $arrayMensagem);
    echo json_encode(array("erro" => true, "mensagem" => $mensagem));
    exit();
}

$imagem_existe = false;
$nomeImagem = '';
if (!empty($_FILES['imagem']['name'])) {

    require_once '../includes/funcoes_imagens.php';

    $extensao = getExtensaoDaImagem($_FILES['imagem']['type']);
    $extensao_valida = verificaSeExtensaoDaImagemSeraValida($extensao);

    if (!$extensao_valida) {
        echo json_encode(array("erro" => true, "mensagem" => "A imagem inserida não é válida.<br/><br/>Insira uma imagem num dos seguintes formatos .jpg, .png, .gif"));
        exit();
    } else {
        $_GLOBALS['imagem_existe'] = true;
        $date = new DateTime();
        $_GLOBALS['nomeImagem'] = $_FILES['imagem']['name'];
        $_GLOBALS['nomeImagem'] = hash('sha256', $_GLOBALS['nomeImagem'] . $date->getTimestamp());
        $_GLOBALS['nomeImagem'] .= '.' . $extensao;

        // guardar e redimensionar as imagens

        $image_dir = 'img';
        $image_dir_path = getcwd() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $image_dir;

        $source = $_FILES['imagem']['tmp_name'];
        $target = $image_dir_path . DIRECTORY_SEPARATOR . $_GLOBALS['nomeImagem'];

        move_uploaded_file($source, $target);

        // create the '400' and '100' versions of the image
        process_image($image_dir_path, $_GLOBALS['nomeImagem']);


        // eliminar as imagens anteriores que estavam associadas ao roteiro
        $imagem_atual_roteiro = $_POST['imagem_atual_roteiro'];
        $targets = array($image_dir_path . DIRECTORY_SEPARATOR . $imagem_atual_roteiro,
            $image_dir_path . DIRECTORY_SEPARATOR . 'gd_' . $imagem_atual_roteiro,
            $image_dir_path . DIRECTORY_SEPARATOR . 'pq_' . $imagem_atual_roteiro
        );

        foreach ($targets as $target) {
            if (file_exists($target)) {
                unlink($target);
            }
        }
    }
}

require_once '../includes/config.php';

////////////////////////////////////////////////////////////////////////////////
// ID do roteiro
$post_parametro_id_roteiro = mysql_real_escape_string($_POST['i']);

////////////////////////////////////////////////////////////////////////////////
// UPDATE NA TABELA - roteiro
$post_parametro_regiao = mysql_real_escape_string(utf8_decode($_POST['regiao']));
$post_parametro_categoria = mysql_real_escape_string(utf8_decode($_POST['categoria']));
$post_parametro_titulo = mysql_real_escape_string(utf8_decode($_POST['titulo']));


$post_parametro_descricao = htmlentities(utf8_decode($_POST['descricao']));
$post_parametro_sobre = htmlentities(utf8_decode($_POST['sobre']));
$post_parametro_infos_uteis = htmlentities(utf8_decode($_POST['infos_uteis']));
$post_parametro_como_chegar = htmlentities(utf8_decode($_POST['como_chegar']));

$sql = "UPDATE roteiro SET  id_regiao          = $post_parametro_regiao,
                                    id_categoria       = $post_parametro_categoria,
                                    titulo             = '$post_parametro_titulo',";

$sql .= (@$_GLOBALS['imagem_existe']) ? " imagem = '" . @$_GLOBALS['nomeImagem'] . "' ," : ' ';

$sql .=" descricao          = '$post_parametro_descricao',
                    sobre              = '$post_parametro_sobre',
                    informacoes_uteis  = '$post_parametro_infos_uteis',
                    como_chegar        = '$post_parametro_como_chegar'
              WHERE id                 = $post_parametro_id_roteiro";


if (mysql_query($sql)) {

    //////////////////////////// TABELA roteiro_tem_tipo ////////////////////////////////////////////////////////////////////
    // eliminar os tipos de roteiro pré-existentes na tabela
    $sql = "DELETE FROM roteiro_tem_tipo WHERE id_roteiro = $post_parametro_id_roteiro";
    mysql_query($sql);

    // inserir os novos tipos de percurso do roteiro
    $array_indexs_percursos = array_keys($_POST['percurso']);
    foreach ($array_indexs_percursos as $index => $value) {
        mysql_query("INSERT INTO roteiro_tem_tipo (id_roteiro, id_tipo) VALUES ($post_parametro_id_roteiro, $value)");
    }

    //////////////////////////// TABELA palavra_chave ///////////////////////////////////////////////////////////////////////
    // eliminar os tipos de roteiro pré-existentes na tabela
    $sql = "DELETE FROM palavra_chave WHERE id_roteiro = $post_parametro_id_roteiro";
    mysql_query($sql);

    // inserir palavras-chave
    $palavras_chave_adicionadas = $_POST['palavras_chave'];
    $array_palavras_chave = explode(",", $palavras_chave_adicionadas);

    foreach ($array_palavras_chave as $palavra) {
        $palavra = utf8_decode($palavra);
        mysql_query("INSERT INTO palavra_chave (id_roteiro, palavra) VALUES ($post_parametro_id_roteiro, '$palavra')");
    }

    // redirecionar no futuro
    echo json_encode(array("erro" => false, "mensagem" => "O roteiro foi alterado com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível alterar o roteiro."));
}
?>