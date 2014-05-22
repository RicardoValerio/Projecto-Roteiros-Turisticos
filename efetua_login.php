<?php require_once 'includes/config.php';

$email = mysql_real_escape_string($_POST['email']);
$password = hash('sha512', mysql_real_escape_string($_POST['password']));

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

    // ::TODO::
    //manter no mesmo local
    header("Location: index.php");
    exit;
} else {

    // ::TODO::
    // dados de login incorretos
    // recuperar a password ou registar-se pela primeira vez...

    echo "esqueceu-se da password ou ainda não se registou...";
}
?>