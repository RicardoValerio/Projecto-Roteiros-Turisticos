<?php

include 'includes/funcoes_imagens.php';

$extensao           = getExtensaoDaImagem($_FILES['imagem']['type']);
$extensao_valida    = verificaSeExtensaoDaImagemSeraValida($extensao);



if (!isset($_FILES['imagem']) || !$extensao_valida) {

    echo "a imagem n está definida ou a extensão do ficheiro n é uma imagem válida";

    echo " extensão: $extensao";
    echo "<br />";
    print_r($_FILES);

    die;



}else{


    include_once 'includes/config.php';

            $titulo         = mysql_real_escape_string(utf8_encode($_POST['titulo']));

            $nomeImagem     = mysql_real_escape_string(utf8_encode($_FILES['imagem']['name']));

            $date = new DateTime();
            $nomeImagem     = hash( 'sha256', $nomeImagem . $date->getTimestamp() );
            $nomeImagem     .= '.' . $extensao;

            $descricao      = mysql_real_escape_string(utf8_encode($_POST['descricao']));
            $sobre          = mysql_real_escape_string(utf8_encode($_POST['sobre']));
            $infos_uteis    = mysql_real_escape_string(utf8_encode($_POST['infos_uteis']));
            $como_chegar    = mysql_real_escape_string(utf8_encode($_POST['como_chegar']));

            $sql = "INSERT INTO roteiro
            (
                id_regiao,
                id_utilizador,
                id_categoria,
                titulo,
                imagem,
                descricao,
                sobre,
                informacoes_uteis,
                como_chegar
                )
        VALUES
        (
            " . $_POST['regiao'] . ", "
            . $_POST['u'] . ", "
            . $_POST['categoria'] . ", '"
            . $titulo . "' , '"
            . $nomeImagem . "','"
            . $descricao . "','"
            . $sobre . "','"
            . $infos_uteis . "','"
            . $como_chegar . "'
            )";


        if (mysql_query($sql)) {


            // guardar e redimensionar as imagens

            $image_dir          = 'img';
            $image_dir_path     = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

            $source             = $_FILES['imagem']['tmp_name'];
            $target             = $image_dir_path . DIRECTORY_SEPARATOR . $nomeImagem;

            move_uploaded_file($source, $target);

            // create the '400' and '100' versions of the image
            process_image($image_dir_path, $nomeImagem);



            // inserir tipos de percurso do roteiro
            $id_ultimo_roteiro_inserido = mysql_insert_id();

            $array_indexs_percursos = array_keys($_POST['percurso']);
            foreach ($array_indexs_percursos as $index => $value) {
                mysql_query("INSERT INTO roteiro_tem_tipo (id_roteiro, id_tipo) VALUES ($id_ultimo_roteiro_inserido, $value)");
            }

            // inserir palavras-chave
            $palavras_chave_adicionadas = $_POST['palavras_chave'];
            $array_palavras_chave = explode(",", $palavras_chave_adicionadas);

            foreach ($array_palavras_chave as $palavra) {
                $palavra = utf8_encode($palavra);
                mysql_query("INSERT INTO palavra_chave (id_roteiro, palavra) VALUES ($id_ultimo_roteiro_inserido, '$palavra')");
            }






            // redireccionar
            echo "sucesso, inserido com tranquilidade, falta agora redireccionar!";


        }else{
            echo "erro, por favor contacte a empresa onde pagou pela porcaria de software xD...";
        }
}
?>
