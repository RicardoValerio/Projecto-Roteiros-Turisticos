<?php

function verificaAreaExiste() {
    if (isset($_GET['area'])) {
        $area_escolhida = $_GET['area'];
    } else {
        $area_escolhida = 'inicio';
    }
    return $area_escolhida;
}

function verificaAreaIndex($elem) {
    $area_escolhida = verificaAreaExiste();

    switch ($area_escolhida) {
        case 'destinos': {
                $tituloEscolhido = 'Destinos | ' . NOME_EMPRESA;
                $areaEscolhida = 'area_categorias.php';
                $bannerEscolhido = 'banner.php';
            } break;
        case 'o_que_procura': {
                $tituloEscolhido = 'O que procura? | ' . NOME_EMPRESA;
                $areaEscolhida = 'area_pesquisa.php';
                $bannerEscolhido = 'banner.php';
            } break;
        case 'noticias': {
                $tituloEscolhido = 'Notícias | ' . NOME_EMPRESA;
                $areaEscolhida = 'area_noticias.php';
                $bannerEscolhido = 'banner.php';
            } break;
        case 'galeria': {
                $tituloEscolhido = 'Galeria | ' . NOME_EMPRESA;
                $areaEscolhida = 'area_galeria.php';
                $bannerEscolhido = 'banner.php';
            } break;
        case 'termos_condicoes': {
                $tituloEscolhido = 'Termos e Condições | ' . NOME_EMPRESA;
                $areaEscolhida = 'area_termos_condicoes.php';
                $bannerEscolhido = 'banner.php';
            } break;
        case 'inicio':
        default: {
                $tituloEscolhido = NOME_EMPRESA;
                $areaEscolhida = 'area_home.php';
                $bannerEscolhido = 'slideshow.php';
            } break;
    }

    switch ($elem) {
        case 'titulo': {
                return $tituloEscolhido;
            } break;
        case 'linkNavegacao': {
                return $areaEscolhida;
            } break;
        case 'banner': {
                return $bannerEscolhido;
                break;
            }
    }
}

function verificaAreaDestinos() {
    $areaEscolhida = '';
    if (isset($_GET['categoria'])) {
        $areaEscolhida = 'categorias/area_categoria.php';
    } else if (isset($_GET['roteiro'])) {
        $areaEscolhida = 'categorias/area_roteiro.php';
    } else {
        $areaEscolhida = 'categorias/area_home.php';
    }
    return $areaEscolhida;
}

?>