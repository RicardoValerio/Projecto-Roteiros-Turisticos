<?php

session_start();
require_once 'includes/config.php';

$idRoteiro = $_SESSION['roteiro'];

define('MENSAGEM_ERRO', 'Pedimos desculpa mas de momento não foi possível registar o seu voto.');
define('MENSAGEM_TEMPO', 'O seu voto já foi contabilizado anteriormente.');
define('MENSAGEM_SUCESSO', 'O seu voto foi submetido com sucesso.');

$votacao = mysql_real_escape_string($_POST['classificacao']);
$now = date("Y-m-d H:i:s");

if (is_numeric($votacao) && $votacao > 0 && $votacao < 6) {
    //numero valido
    //verificar ip
    $ip = get_client_ip();

    $sql_verificaIp = "SELECT timestamp FROM voto_temp WHERE ip='$ip' and id_roteiro=$idRoteiro ORDER BY timestamp DESC";
    $resultado_verificaIp = mysql_query($sql_verificaIp);

    $numLinhas = mysql_num_rows($resultado_verificaIp);

    $differenceInMinutes = 0;

    if ($numLinhas) {
        $linhaDatas = mysql_fetch_assoc($resultado_verificaIp);
        $lastDate = $linhaDatas['timestamp'];

        $differenceInMinutes = (strtotime($now) - strtotime($lastDate))/60;
    }

    if (!$numLinhas || $differenceInMinutes > 20) {
        //registar ip
        $sql_registaIp = "INSERT INTO voto_temp (id_roteiro, ip, timestamp) VALUES ($idRoteiro, '$ip', '$now')";

        if (mysql_query($sql_registaIp)) {
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

                    if(!$numVotos) {
                        $texto = '';
                    } else if ($media <= 2) {
                        $texto = VOTOS_BAIXO;
                    } else if ($media >= 4) {
                        $texto = VOTOS_ALTO;
                    } else {
                        $texto = VOTOS_MEDIO;
                    }
                    
                    $textoVotacoes = ($numVotos==1) ? ' votação' : ' votações';

                    echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_SUCESSO, "votos" => number_format($numVotos, 0, ",", '.'), "classificacao" => number_format($media, 2, ",", '.'), "texto" => $texto, "textoVotacoes" => $textoVotacoes));
                }
            } else {
                echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_ERRO));
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

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

?>
