<?php

session_start();

/* * *******
 *  VERIFICAÇÃO DE DADOS
 * ******* */

if (!strlen(trim($_POST['titulo'])) || empty($_FILES['imagem']['name']) || !isset($_POST['percurso']) || !strlen(trim($_POST['descricao'])) || !strlen(trim($_POST['sobre'])) || !strlen(trim($_POST['infos_uteis'])) || !strlen(trim($_POST['como_chegar'])) || !strlen(trim($_POST['palavras_chave']))) {
    $arrayMensagem = array();

    if (!strlen(trim($_POST['titulo'])))
        array_push($arrayMensagem, "Insira o título do roteiro.");
    if (empty($_FILES['imagem']['name']))
        array_push($arrayMensagem, "Insira uma imagem.");
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
} else {

    include 'includes/funcoes_imagens.php';

    $extensao = getExtensaoDaImagem($_FILES['imagem']['type']);
    $extensao_valida = verificaSeExtensaoDaImagemSeraValida($extensao);


    if (!$extensao_valida) {
        echo json_encode(array("erro" => true, "mensagem" => "A imagem inserida não é válida.<br/><br/>Insira uma imagem num dos seguintes formatos .jpg, .png, .gif"));
        exit();
    } else {
        include 'includes/config.php';

        $nomeImagem = mysql_real_escape_string(utf8_decode($_FILES['imagem']['name']));

        $date = new DateTime();
        $nomeImagem = hash('sha256', $nomeImagem . $date->getTimestamp());
        $nomeImagem .= '.' . $extensao;

        $titulo = mysql_real_escape_string(utf8_decode($_POST['titulo']));
        $descricao = mysql_real_escape_string(utf8_decode($_POST['descricao']));
        $sobre = mysql_real_escape_string(utf8_decode($_POST['sobre']));
        $infos_uteis = mysql_real_escape_string(utf8_decode($_POST['infos_uteis']));
        $como_chegar = mysql_real_escape_string(utf8_decode($_POST['como_chegar']));

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
                . $_SESSION['id_utilizador'] . ", "
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

            $image_dir = 'img';
            $image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

            $source = $_FILES['imagem']['tmp_name'];
            $target = $image_dir_path . DIRECTORY_SEPARATOR . $nomeImagem;

            move_uploaded_file($source, $target);

            // create the versions of the image
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
                $palavra = utf8_decode($palavra);
                mysql_query("INSERT INTO palavra_chave (id_roteiro, palavra) VALUES ($id_ultimo_roteiro_inserido, '$palavra')");
            }

            // redireccionar
            $textoRoteiro = ($_SESSION['tipo_utilizador'] != 'admin') ? 'Obrigado pela sua contribuição.<br/><br/>O seu roteiro foi adicionado com sucesso.<br/><br/>Poderá consultar o roteiro após aprovação do administrador.' : 'O roteiro foi adicionado com sucesso.<br/><br/>Confirme a informação e faça a aprovação do roteiro em seguida.';
            $user = $_SESSION['tipo_utilizador'];
            $url = ($_SESSION['tipo_utilizador'] != 'admin') ? '' : "index.php?area=editar_roteiro&id=$id_ultimo_roteiro_inserido";
            echo json_encode(array("erro" => false, "mensagem" => $textoRoteiro, "url" => $url, "user" => '$user'));
        } else {
            echo json_encode(array("erro" => true, "mensagem" => "Não foi possível adicionar o roteiro."));
        }
    }
}
?>
