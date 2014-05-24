<?php 
session_start();
require_once 'includes/config.php';

$email = mysql_real_escape_string(@$_POST['email']);

$post = (isset($_SESSION['url'])) ? mysql_real_escape_string($_SESSION['url']) : 'index.php';
if(!strlen(trim($post))) $post = 'index.php';
    
$password = hash('sha512', mysql_real_escape_string(@$_POST['password']));

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName
		WHERE email = '$email'
		AND password = '$password'";

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

if (mysql_num_rows($result)) {

    session_start();
    $_SESSION['nome'] = $row['nome'];
    $_SESSION['tipo_utilizador'] = ($row['id_tipo_utilizador'] == 1) ? 'user' : 'admin';
    $_SESSION['id_utilizador'] = $row['id'];

    echo json_encode(array("erro"=>false, "mensagem"=>"esqueceu-se da password ou ainda não se registou..."));
    exit();
    
} else {

    // ::TODO::
    // dados de login incorretos
    // recuperar a password ou registar-se pela primeira vez...

    //echo "esqueceu-se da password ou ainda não se registou...";
    echo json_encode(array("erro"=>true, "mensagem"=>"esqueceu-se da password ou ainda não se registou..."));
    exit();
    
}
?>