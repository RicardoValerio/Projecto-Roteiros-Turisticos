<?php require_once 'includes/config.php';

$nome = mysql_real_escape_string($_POST['nome']);
$email = mysql_real_escape_string($_POST['email']);
$password = hash('sha512', mysql_real_escape_string($_POST['password']));

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName WHERE email = '$email'";

if (!mysql_num_rows(mysql_query($sql))) {

    $sql = "INSERT INTO $tableName (id_tipo_utilizador, nome, email, password)
			VALUES ( 1, '$nome', '$email', '$password' )";

    if (mysql_query($sql)) {
        /*
         * enviar email para fazer a verificação do email
         */

        echo "Registo efetuado com sucesso! Verifique o seu email para ativar a conta!";
    }
} else {

    // ::TODO::
    // o utilizador já existe. fazer login ou recuperar a password
    // redireccionar para o login
    
    echo "já existe esse utilizador na base de dados...esqueceu-se da password??";
}
?>