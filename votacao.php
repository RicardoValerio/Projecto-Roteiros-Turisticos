<?php

session_start();
require_once 'includes/config.php';

$idRoteiro = $_SESSION['roteiro'];

define('MENSAGEM_ERRO', 'Pedimos desculpa mas de momento não foi possível registar o seu voto.');
define('MENSAGEM_TEMPO', 'O seu voto já foi contabilizado anteriormente.');
define('MENSAGEM_SUCESSO', 'O seu voto foi submetido com sucesso.');

$votacao = mysql_real_escape_string($_POST['classificacao']);

if (is_numeric($votacao) && $votacao > 0 && $votacao < 6) {
    //numero valido
    //verificar ip
    
    
    if(0==0) {//ip nao existe nos ultimos 20min

        //registar ip
        
        

        $sql_registaVoto = "INSERT INTO voto (id_roteiro, classificacao) VALUES ($idRoteiro, $votacao)";
        //inserir o voto
        if (mysql_query($sql_registaVoto)) {
            $sql_classificacao = "SELECT IFNULL(sum(classificacao),0) as classificacao FROM voto WHERE id_roteiro=$idRoteiro";
            $sql_numVotos = "SELECT IFNULL(count(id),0) as numVotos FROM voto WHERE id_roteiro=$idRoteiro";

            if (($resultado_classificacao = mysql_query($sql_classificacao)) && ($resultado_numVotos = mysql_query($sql_numVotos))) {
                $row_classificacao = mysql_fetch_assoc($resultado_classificacao);
                $classificacao = $row_classificacao['classificacao'];

                $row_numVotos = mysql_fetch_assoc($resultado_numVotos);
                $numVotos = $row_numVotos['numVotos'];

                $media = ($numVotos == 0) ? 0 : $classificacao / $numVotos;

                if($media<=2) {
                    $texto = VOTOS_BAIXO;
                } else if($media >= 4) {
                    $texto = VOTOS_ALTO;
                } else {
                    $texto = VOTOS_MEDIO;
                }

                echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_SUCESSO, "votos" => number_format($numVotos, 0, ",", '.'), "classificacao" => number_format($media, 2, ",", '.'), "texto" => $texto));
            }
        } else {
            echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_ERRO));
        }
    } else {
        echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_TEMPO));
    }
} else {
    echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_ERRO));
}
?>
