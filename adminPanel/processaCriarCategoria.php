<?php

$post_parametro_nome_da_nova_categoria = @mysql_real_escape_string($_POST['nome_da_nova_categoria']);
$post_parametro_imagem_da_nova_categoria = @mysql_real_escape_string(utf8_decode($_POST['imagem']));

if(strlen(trim($post_parametro_nome_da_nova_categoria)) == 0) {
    echo json_encode(array("erro" => true, "mensagem" => "Preencha o Nome da nova Categoria."));
    exit();
}


$imagem_existe = false;
$nomeImagem = '';
if (!empty($_FILES['imagem']['name'])) {

    require_once '../includes/funcoes_imagens.php';

print_r($_POST);
print_r($_FILES);

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


        // insirir nova categoria na BD
		require_once '../includes/config.php';

		$sql = "INSERT INTO categoria (
										nome,
										imagem
									   )
				VALUES (
						'$post_parametro_nome_da_nova_categoria' ,
						' " .  $_GLOBALS['nomeImagem'] . "'
						)";

		if (mysql_query($sql)) {
		    echo json_encode(array("erro" => false, "mensagem" => "A categoria foi criada com sucesso."));
		} else {
		    echo json_encode(array("erro" => true, "mensagem" => "Não foi possível criar a categoria."));
		}


    }
}else{
        echo json_encode(array("erro" => true, "mensagem" => "Por favor insira uma imagem...<br/><br/>Terá de ser uma imagem num dos seguintes formatos .jpg, .png, .gif"));
}
?>
