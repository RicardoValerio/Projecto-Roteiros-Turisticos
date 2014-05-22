<?php


print_r($_POST);
print_r($_FILES);


include '../config.php';

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
						como_chegar,
						ativo
					)
			VALUES
					(
						" . $_POST['regiao'] . ", "
						. $_POST['u'] . ", "
						. $_POST['categoria'] . ", '"
						. $_POST['titulo'] . "' , '"
						. $_FILES['imagem']['name'] . "','"
						. $_POST['descricao'] . "','"
						. $_POST['sobre'] . "','"
						. $_POST['infos_uteis'] . "','"
						. $_POST['como_chegar'] . "',
						0
					)";


if(mysql_query($sql)){

	$id_ultimo_roteiro_inserido = mysql_insert_id();

	// inserir tipos de percurso do roteiro

	$array_indexs_percursos = array_keys($_POST['percurso']);
	foreach ($array_indexs_percursos as $index => $value) {

		@mysql_query("INSERT INTO roteiro_tem_tipo (id_roteiro, id_tipo) VALUES ($id_ultimo_roteiro_inserido, $value)");
	}


	// inserir palavras-chave

	$palavras_chave_adicionadas  = $_POST['palavras_chave'];
	$array_palavras_chave = explode(",", $palavras_chave_adicionadas);

	foreach ($array_palavras_chave as $palavra) {

		@mysql_query("INSERT INTO palavra_chave (id_roteiro, palavra) VALUES ($id_ultimo_roteiro_inserido, '$palavra')");
		echo "palavras chave inserida com sucesso xD";
	}

}

?>
