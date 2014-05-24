<?php
function getHash($prefix, $id) {
    return hash('sha512', $prefix.$id);
}

function devolveUrlActual() {
    //url até ao ? sem a directoria
    $urlInicial = basename($_SERVER['SCRIPT_NAME']);

    //variaveis
    $variaveis = $_SERVER['QUERY_STRING'];

    return $urlInicial . '?' . $variaveis;
}
?>
