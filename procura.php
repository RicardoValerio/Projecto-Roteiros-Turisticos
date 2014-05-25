<?php
require 'includes/config.php';

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a href="urlString">';
$html .= '<h3>tituloString</h3>';
$html .= '<h3>categoriaString | regiaoString | </h3>';
$html .= '<h4>descricaoString</h4>';
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
            roteiro.descricao,
            categoria.nome as "categoria",
            regiao.nome as "regiao",
            palavra_chave.palavra
        FROM
            ((roteiro LEFT JOIN palavra_chave ON roteiro.id = id_roteiro)
            LEFT JOIN regiao ON roteiro.id_regiao = regiao.id)
            LEFT JOIN categoria ON roteiro.id_categoria = categoria.id
        WHERE
            roteiro.ativo = 1
            AND titulo LIKE "%' . $search_string . '%"
            OR categoria.nome LIKE "%' . $search_string . '%"
            OR roteiro.descricao LIKE "%' . $search_string . '%"
            OR regiao.nome LIKE "%' . $search_string . '%"
            OR palavra_chave.palavra LIKE "%' . $search_string . '%"
        GROUP BY roteiro.id';

    // Do Search
    $result = mysql_query($query);


    if(mysql_num_rows($result)) {
        while($row =  mysql_fetch_assoc($result)) {
            $displayTitulo = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", utf8_encode($row['titulo']));

            $displayCategoria = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", utf8_encode($row['categoria']));

            $displayRegiao = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", utf8_encode($row['regiao']));

            $displayDescricao = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", utf8_encode($row['descricao']));

            $displayPalavraChave = preg_replace("/" . $search_string . "/i", "<b class='highlight'>" . $search_string . "</b>", utf8_encode($row['palavra']));

            $display_url = 'index.php?area=destinos&roteiro=' . $row['id'];


            // Insert Name
            $output = str_replace('descricaoString', $displayDescricao, $html);

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