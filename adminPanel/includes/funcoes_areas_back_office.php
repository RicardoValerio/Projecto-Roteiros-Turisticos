<?php

function verificaAreaExiste() {
    if (isset($_GET['area'])) {
        $area_escolhida = $_GET['area'];
    } else {
        $area_escolhida = 'inicio';
    }
    return $area_escolhida;
}

function verificaAreaIndexBackOffice() {
    $area_escolhida = verificaAreaExiste();

    switch ($area_escolhida) {
        case 'gerirRoteiros':
            $areaEscolhida = 'gerirRoteiros.php';
            break;
        case 'editar_roteiro':
            $areaEscolhida = 'editarRoteiros.php';
            break;
        case 'gerirComentarios':
            $areaEscolhida = 'gerirComentarios.php';
            break;
        case 'editar_comentario':
            $areaEscolhida = 'editarComentarios.php';
            break;
        case 'gerirUtilizadores':
            $areaEscolhida = 'gerirUtilizadores.php';
            break;
        case 'editar_utilizador':
            $areaEscolhida = 'editarUtilizadores.php';
            break;
        case 'editarTermosCondicoes':
            $areaEscolhida = 'editarTermosCondicoes.php';
            break;
        case 'inserir':
        default:
            $areaEscolhida = '../area_inserir_roteiro.php';
    }

    return $areaEscolhida;
}

?>