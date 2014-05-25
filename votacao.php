<?php
session_start();
require_once 'includes/config.php';

$idRoteiro = $_SESSION['roteiro'];

define('MENSAGEM_ERRO', 'Pedimos desculpa mas de momento não foi possível registar o seu voto.');
define('MENSAGEM_TEMPO', 'O seu voto já foi contabilizado anteriormente.');
define('MENSAGEM_SUCESSO', 'O seu voto foi submetido com sucesso.');

$votacao = mysql_real_escape_string($_POST['classificacao']);

if(is_numeric($votacao) && $votacao>0 && $votacao<6) {
    //numero valido
    
    //verificar ip
    
    //guardar voto na tabela de ip
    
    //guardar voto na classificacao
    
    //atualizar as label com os votos e pontuacao
    
    echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_SUCESSO, "votos" => 4, "classificacao" => 1.5, "texto" => "Alto"));
    
} else {
    echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_ERRO));
}
?>
