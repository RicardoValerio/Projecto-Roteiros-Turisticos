<?php

/* * **********************************************
 * TODO:
 * 		fazer o include do ficheiro config.php e passar todas as funções
 * 	de base de dados para a forma procedimental mais deprecated (mysql_*)
 *
 * 	formatar rigorosamente o output do html
 *
 * ******************************************* */

/* * **********************************************
  Search Functionality
 * ********************************************** */

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a target="_blank" href="urlString">';
$html .= '<h3>tituloString</h3>';
$html .= '<h3>categoriaString | regiaoString | </h3>';
$html .= '<h4>sobreString</h4>';
$html .= '<h6>palavraChaveString</h6>';
$html .= '</a>';
$html .= '</li>';

// Get Search
// @$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
@$search_string = preg_replace("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i", " ", $_POST['query']);
$search_string = mysql_real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {

    // Build Query

    $query = 'SELECT
                        roteiro.id,
                        roteiro.titulo,
                        roteiro.sobre,
                        categoria.nome as "categoria",
                        regiao.nome as "regiao",
                        palavra_chave.palavra
                    FROM
                        ((roteiro LEFT JOIN palavra_chave ON roteiro.id = id_roteiro)
                        LEFT JOIN regiao ON roteiro.id_regiao = regiao.id)
                            LEFT JOIN
                        categoria ON roteiro.id_categoria = categoria.id
                    WHERE
                        titulo LIKE "%' . $search_string . '%"
                            OR roteiro.sobre LIKE "%' . $search_string . '%"
                            OR categoria.nome LIKE "%' . $search_string . '%"
                            OR regiao.nome LIKE "%' . $search_string . '%"
                            OR palavra_chave.palavra LIKE "%' . $search_string . '%"
                    GROUP BY roteiro.id';


    // Do Search
    $result = mysql_query($query);
    if ($result) {
        while ($results = mysql_fetch_array($result)) {
            $result_array[] = $results;
        }
    }


    // Check If We Have Results
    if (isset($result_array)) {
        foreach ($result_array as $result) {
            $displayTitulo = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['titulo']);

            $displayCategoria = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['categoria']);

            $displayRegiao = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['regiao']);

            $displaySobre = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['sobre']);

            $displayPalavraChave = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", $result['palavra']);

            $display_url = 'detalheRoteiro.php?id=' . urlencode($result['id']);


            // Insert Name
            $output = str_replace('sobreString', $displaySobre, $html);

            // Insert Function
            $output = str_replace('tituloString', $displayTitulo, $output);

            $output = str_replace('categoriaString', $displayCategoria, $output);
            $output = str_replace('regiaoString', $displayRegiao, $output);
            $output = str_replace('palavraChaveString', $displayPalavraChave, $output);

            // Insert URL
            $output = str_replace('urlString', $display_url, $output);

            // Output
            echo($output);
        }
    } else {

        // Format No Results Output

        $output = '<li class="result">';
        $output .= '<a target="_blank" href="javascript:void(0);">';
        $output .= '<h3>Desculpe =(</h3>';
        $output .= '<h4><b>Nenhum resultado encontrado...</b></h4>';
        $output .= '</a>';
        $output .= '</li>';

        // Output
        echo($output);
    }
}
?>