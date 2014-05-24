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

/* gera uma palavra/numero aleatorio que tem numeros e pode ter maiusculas e minusculas*/
function geraSenha($tamanho, $letrasMaiusculas, $letrasMinusculas) {
	$senhaGerada = '';
	$todosCaracteres = '';
	$minusculas = 'abcdefghijklmnopqrstuvwxyz';
	$maiusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$numeros = '1234567890';
	
	//tem de ter pelo menos numeros e dp pode ter maiusculas e minusculas dependendo dos argumentos passados
	$todosCaracteres .= $numeros;
	if($letrasMaiusculas) $todosCaracteres .= $maiusculas;
	if($letrasMinusculas) $todosCaracteres .= $minusculas;
	
	$lenghtTodosCaracteres = strlen($todosCaracteres);
	
	for ($n = 1; $n <= $tamanho; $n++) {
		//devolve aleatoriamente um numero inteiro entre 1 e o comprimento de todos os caracteres juntos
		$rand = mt_rand(1, $lenghtTodosCaracteres);
		//adicionar à senha o caracter com o indice gerado aleatoriamente
		$senhaGerada .= $todosCaracteres[$rand-1];
	}
	return $senhaGerada;
}
/* end gera senha*/
?>
