<?php
require_once '../includes/config.php';

// print_r($_POST);
// print_r($_FILES);

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
        $imagem_atual_categoria = $_POST['imagem_atual_categoria'];
        $targets = array($image_dir_path . DIRECTORY_SEPARATOR . $imagem_atual_categoria,
            $image_dir_path . DIRECTORY_SEPARATOR . 'gd_' . $imagem_atual_categoria,
            $image_dir_path . DIRECTORY_SEPARATOR . 'pq_' . $imagem_atual_categoria
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
$post_parametro_id_categoria = mysql_real_escape_string($_POST['i']);

////////////////////////////////////////////////////////////////////////////////
// UPDATE NA TABELA - categoria
$post_parametro_nome_da_categoria = mysql_real_escape_string($_POST['nome_da_categoria']);

$sql = "UPDATE categoria
		SET  categoria.nome = '$post_parametro_nome_da_categoria'";

$sql .= (@$_GLOBALS['imagem_existe']) ? ", categoria.imagem = '" . @$_GLOBALS['nomeImagem'] . "' " : ' ';

$sql .=	" WHERE categoria.id = $post_parametro_id_categoria";

if (mysql_query($sql)) {
    // redirecionar no futuro
    echo json_encode(array("erro" => false, "mensagem" => "A Categoria foi alterada com sucesso."));
} else {
    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível alterar a Categoria."));
}
?>