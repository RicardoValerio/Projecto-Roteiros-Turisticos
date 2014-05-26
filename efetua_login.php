<?php 
session_start();
require_once 'includes/config.php';

$email = mysql_real_escape_string(@$_POST['email']);

$post = (isset($_SESSION['url']) && strlen(trim($_SESSION['url']))) ? strstr(mysql_real_escape_string($_SESSION['url']), '&log=login', true) : 'index.php';
    
$password = hash('sha512', mysql_real_escape_string(@$_POST['password']));

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName
		WHERE email = '$email'
		AND password = '$password' and ativo = 1 and bloqueado=0";

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

if (mysql_num_rows($result)) {
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['tipo_utilizador'] = ($row['id_tipo_utilizador'] == 1) ? 'user' : 'admin';
    $_SESSION['id_utilizador'] = $row['id'];

    echo json_encode(array("erro"=>false, "mensagem"=>$post));
    
} else {
    
    echo json_encode(array("erro"=>true, "mensagem"=>"Dados de login incorretos!"));
    
}
?>