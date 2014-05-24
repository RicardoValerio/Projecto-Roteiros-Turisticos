<?php
session_start();
require_once 'includes/config.php';

$email = mysql_real_escape_string(@$_POST['email']);

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName
		WHERE email = '$email' and ativo = 1";

$result = mysql_query($sql);

if (mysql_num_rows($result)) {
    
    //gerar nova password
    
    
    //gravar a nova password na base de dados
    
    
    //enviar email com nova password
    
    
    echo json_encode(array("erro"=>false, "mensagem"=>"A nova password foi enviada para o seu email."));
    
} else {
    
    echo json_encode(array("erro"=>true, "mensagem"=>"Não existe nenhum utilizador registado com este email!"));
    
}
?>
