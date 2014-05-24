<?php
require_once 'includes/config.php';
require_once 'includes/funcoes.php';
require_once 'includes/funcoes_email.php';

$urlActual = strstr("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'newsletterSubmitEmail.php', true);

define('MENSAGEM_ERRO', 'Pedimos desculpa mas de momento não foi possível adicionar o seu email à newsletter dos roteiros turísticos');
define('MENSAGEM_ATIVO', 'O seu email já foi adicionado à newsletter dos roteiros turísticos');
define('MENSAGEM_SUCESSO', 'Obrigado por se ter inscrito na newsletter dos roteiros turísticos. <br /><br /> Dentro de momentos irá receber um email pedindo-lhe que confirme a sua intenção, bastando para isso clicar no link fornecido.');
define('SUBJECT', 'Newsletter '.NOME_EMPRESA);

$email = mysql_real_escape_string($_POST['subscrever']);

$sql_verificaEmail = "SELECT id, ativo FROM newsletter WHERE email='$email'";
$resultado_verificaEmail = mysql_query($sql_verificaEmail);

if(!mysql_num_rows($resultado_verificaEmail)) {
    $sql = "INSERT INTO newsletter (email) VALUES ('$email')";

    if(mysql_query($sql)) {
        $id = mysql_insert_id();
        $hash = getHash('newsletter', $id);

        $body_head_cliente = '<p>Obrigado por aderir à nossa newsletter!</p>';
        $body_corpo_cliente = '<p>Para confirmar a sua intenção de receber a newsletter dos roteiros turísticos proceda à validação do email.</p>';
        $linkValidarEmail = '<p style="align:center;"><a href="' . $urlActual . 'index.php?area=newsletter&token=' . $hash . '" style="background:#4183c4;padding:6px;color:white;text-decoration:none;padding-left:8px;padding-right:8px;border-width:0;border-radius:5px" target="_blank">Validar endereço de email</a></p>';

        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos, </p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo" width="150">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.$linkValidarEmail.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        $sql_hash = "UPDATE newsletter set hash='$hash' WHERE id=$id";

        if(enviaEmail(SUBJECT, $body, $email, $email) && mysql_query($sql_hash)) {
            echo MENSAGEM_SUCESSO;
        } else {
            echo MENSAGEM_ERRO;
        }
    } else {
        echo MENSAGEM_ERRO;
    }
} else {

    $row = mysql_fetch_assoc($resultado_verificaEmail);
    if($row['ativo']) {
        echo MENSAGEM_ATIVO;
    } else {
        $id = $row['id'];
        $hash = getHash('newsletter',$id);

        $body_head_cliente = '<p>Obrigado por aderir à nossa newsletter!</p>';
        $body_corpo_cliente = '<p>Para confirmar a sua intenção de receber a newsletter dos roteiros turísticos proceda à validação do email.</p>';
        $linkValidarEmail = '<p style="align:center;"><a href="' . $urlActual . 'index.php?area=newsletter&token=' . $hash . '" style="background:#4183c4;padding:6px;color:white;text-decoration:none;padding-left:8px;padding-right:8px;border-width:0;border-radius:5px" target="_blank">Validar endereço de email</a></p>';

        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos,</p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo" width="150">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.$linkValidarEmail.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        $sql_hash = "UPDATE newsletter set hash='$hash' WHERE id=$id";

        if(enviaEmail(SUBJECT, $body, $email, $email) && mysql_query($sql_hash)) {
            echo MENSAGEM_SUCESSO;
        } else {
            echo MENSAGEM_ERRO;
        }
    }
}
?>