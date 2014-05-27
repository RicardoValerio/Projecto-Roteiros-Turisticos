<?php

//  TODO ::   tratar do update da imagem


$imagem_existe = false;
$nomeImagem = '';

if (!empty($_FILES['imagem']['name'])) {

    include '../includes/funcoes_imagens.php';

    $extensao = getExtensaoDaImagem($_FILES['imagem']['type']);
    $extensao_valida = verificaSeExtensaoDaImagemSeraValida($extensao);


    if (!$extensao_valida) {

        echo "a extensão do ficheiro n é uma imagem válida para a aplicação";
        print_r($_FILES);
        die;
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

include '../includes/config.php';

////////////////////////////////////////////////////////////////////////////////
// ID do roteiro
$post_parametro_id_roteiro = mysql_real_escape_string($_POST['i']);

////////////////////////////////////////////////////////////////////////////////
// UPDATE NA TABELA - roteiro
$post_parametro_regiao = mysql_real_escape_string($_POST['regiao']);
$post_parametro_categoria = mysql_real_escape_string($_POST['categoria']);
$post_parametro_titulo = mysql_real_escape_string($_POST['titulo']);


$post_parametro_descricao = mysql_real_escape_string($_POST['descricao']);
$post_parametro_sobre = mysql_real_escape_string($_POST['sobre']);
$post_parametro_infos_uteis = mysql_real_escape_string($_POST['infos_uteis']);
$post_parametro_como_chegar = mysql_real_escape_string($_POST['como_chegar']);



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
        $palavra = utf8_encode($palavra);
        mysql_query("INSERT INTO palavra_chave (id_roteiro, palavra) VALUES ($post_parametro_id_roteiro, '$palavra')");
    }


    // redirecionar no futuro
    echo "sucesso, foi tudo actualizado com tranquilidade xD <br><br>";
    print_r($_POST);
} else {
    echo "erro! contacte a empresa a quem pagou por esta porcaria de software..." . mysql_error();
}
?>