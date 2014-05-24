<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/funcoes.php';
require_once 'includes/funcoes_email.php';

define('MENSAGEM_ERRO', 'Não existe nenhum utilizador registado com este email!');
define('MENSAGEM_NAO_POSSIVEL', 'Não foi possível fazer a recuperação da password. Tente mais tarde por favor.');
define('MENSAGEM_SUCESSO', 'A nova password foi enviada para o seu email.');
define('SUBJECT', 'Recuperar Password ' . NOME_EMPRESA);

$email = mysql_real_escape_string(@$_POST['email']);

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName
		WHERE email = '$email' and ativo = 1";

$result = mysql_query($sql);

if (mysql_num_rows($result)) {

    $row = mysql_fetch_assoc($result);
    $id = $row['id'];
    

    //gerar nova password
    $pass = geraSenha(8, true, true);

    //gravar a nova password na base de dados
    $passEncriptada = hash('sha512', $pass);

    $sql_pass = "UPDATE $tableName set password='$passEncriptada' WHERE id=$id";

    if (mysql_query($sql_pass)) {       
        $body_head_cliente = '<p>A sua password foi alterada com sucesso.</p>';
        $body_corpo_cliente = '<p>Password: '.$pass.'</p>';
        
        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos, </p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo" width="150">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        if (enviaEmail(SUBJECT, $body, $email, $email)) {
            echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_SUCESSO));
        } else {
            echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_NAO_POSSIVEL));
        }
    } else {
        echo json_encode(array("erro" => false, "mensagem" => MENSAGEM_NAO_POSSIVEL));
    }
} else {

    echo json_encode(array("erro" => true, "mensagem" => MENSAGEM_ERRO));
}
?>
