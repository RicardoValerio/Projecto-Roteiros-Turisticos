<?php
$host='localhost';
$user='root';
$pass='';
$db='roteiros_turisticos';


$link = mysql_connect($host, $user, $pass);
if (!$link) {
	die('Não foi possível fazer a ligação: ' . mysql_error());
}

$db_selected = mysql_select_db($db, $link);
if (!$db_selected) {
	die ('Não está autorizado a utilizar a base de dados: ' . mysql_error());
}

//VARIAVEIS GLOBAIS
define('NOME_EMPRESA', 'Roteiros Turisticos');
define('USERNAME_EMAIL', 'geral.roteiros.turisticos@gmail.com');
define('PASSWORD_EMAIL', 'Europeia2014');

?>
