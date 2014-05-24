<?php
include_once '../includes/config.php';

print_r($_POST);
print_r($_FILES);

$titulo = mysql_real_escape_string(utf8_encode($_POST['titulo']));
$nomeImagem = mysql_real_escape_string(utf8_encode($_FILES['imagem']['name']));
$descricao = mysql_real_escape_string(utf8_encode($_POST['descricao']));
$sobre = mysql_real_escape_string(utf8_encode($_POST['sobre']));
$infos_uteis = mysql_real_escape_string(utf8_encode($_POST['infos_uteis']));
$como_chegar = mysql_real_escape_string(utf8_encode($_POST['como_chegar']));

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

    $id_ultimo_roteiro_inserido = mysql_insert_id();

    // inserir tipos de percurso do roteiro

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
}
?>
