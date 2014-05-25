<?php
require_once 'includes/config.php';
require_once 'includes/funcoes.php';
require_once 'includes/funcoes_email.php';

$urlActual = strstr("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'efetua_registo.php', true);

define('MENSAGEM_ERRO', 'O email escolhido já existe.<br /><br />Aceda à área de login para entrar na sua conta. Caso não se lembre da password proceda à recuperação da mesma.');
define('MENSAGEM_SUCESSO', 'Obrigado por se ter registado nos roteiros turísticos. <br /><br /> Dentro de momentos irá receber um email pedindo-lhe que confirme a sua intenção, bastando para isso clicar no link fornecido.');
define('MENSAGEM_ERRO_REGISTO', 'Pedimos desculpa mas de momento não foi possível efetuar o seu registo. Por favor, volte a tentar mais tarde.');
define('SUBJECT', 'Registo '.NOME_EMPRESA);


$nome = mysql_real_escape_string($_POST['nome']);
$email = mysql_real_escape_string($_POST['email']);
$password = hash('sha512', mysql_real_escape_string($_POST['password']));

$tableName = "utilizador";

$sql = "SELECT * FROM $tableName WHERE email = '$email'";

if (!mysql_num_rows(mysql_query($sql))) {

    $sql = "INSERT INTO $tableName (id_tipo_utilizador, nome, email, password)
			VALUES ( 1, '$nome', '$email', '$password' )";

    if (mysql_query($sql)) {
        $id = mysql_insert_id();
        $hash = getHash('registo', $id);

        $body_head_cliente = '<p>Obrigado por se ter registado nos roteiros turísticos!</p>';
        $body_corpo_cliente = '<p>Para confirmar a sua inscrição proceda à validação do email.</p>';
        $linkValidarEmail = '<p style="align:center;"><a href="' . $urlActual . 'index.php?area=registo&token=' . $hash . '" style="background:#4183c4;padding:6px;color:white;text-decoration:none;padding-left:8px;padding-right:8px;border-width:0;border-radius:5px" target="_blank">Validar registo</a></p>';

        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos, </p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo" width="150">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.$linkValidarEmail.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        $sql_hash = "UPDATE $tableName set hash='$hash' WHERE id=$id";

        if(enviaEmail(SUBJECT, $body, $email, $email) && mysql_query($sql_hash)) {
            echo MENSAGEM_SUCESSO;
        } else {
            echo MENSAGEM_ERRO_REGISTO;
        }

    } else {
        echo MENSAGEM_ERRO_REGISTO;
    }
} else {

    echo MENSAGEM_ERRO;
}
?>