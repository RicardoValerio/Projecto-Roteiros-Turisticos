<?php
require_once 'includes/config.php';
require_once 'includes/funcoes.php';
require_once 'includes/funcoes_email.php';

$urlActual = strstr("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'newsletterSubmitEmail.php', true);


define('MENSAGEM_ERRO', 'Pedimos desculpa mas de momento não foi possível adicionar o seu email à nossa newsletter');
define('MENSAGEM_ATIVO', 'O seu email já está na nossa lista de newsletters');
define('MENSAGEM_SUCESSO', 'O seu email foi adicionado à nossa newsletter. <br /><br /> Foi enviado um email de confirmação, verifique a sua conta para concluir a submissão.');
define('SUBJECT', 'Newsletter'.NOME_EMPRESA);

$email = mysql_real_escape_string($_POST['subscrever']);

$sql_verificaEmail = "SELECT id, ativo FROM newsletter WHERE email='$email'";
$resultado_verificaEmail = mysql_query($sql_verificaEmail);

if(!mysql_num_rows($resultado_verificaEmail)) {
    $sql = "INSERT INTO newsletter (email) VALUES ('$email')";

    if(mysql_query($sql)) {
        $hash = getHash('newsletter', mysql_insert_id());
        
        $body_head_cliente = '<p>Obrigado por aderir à nossa newsletter!</p>';
        $body_corpo_cliente = '<p>Para confirmar a sua submissão acede ao seguinte link: <br/><a href="' . $urlActual . 'confirmaNewsletter.php?newsletter=' . $hash . '"></a>' . $urlActual . 'confirmaNewsletter.php?newsletter=' . $hash . '</p>';

        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos,</p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo" width="150">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        if(enviaEmail(SUBJECT, $body, $email, $email)) {
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
        $hash = getHash('newsletter', $row['id']);
                
        $body_head_cliente = '<p>Obrigado por aderir à nossa newsletter!</p>';
        $body_corpo_cliente = '<p>Para confirmar a sua submissão acede ao seguinte link: <br/><a href="' . $urlActual . 'confirmaNewsletter.php?newsletter=' . $hash . '"></a>' . $urlActual . 'confirmaNewsletter.php?newsletter=' . $hash . '</p>';

        $body_cumprimentos_cliente = '<p>Com os nossos melhores cumprimentos,</p><p>' . NOME_EMPRESA . '</p>';
        $body_logo_cliente = '<img src="cid:logo">';
        $body = '<html><head><style type="text/css">.text_black{color: #000000;}</style></head><body><div class="text_black">'.$body_head_cliente.'<br/>'.$body_corpo_cliente.'<br />'.$body_cumprimentos_cliente.$body_logo_cliente.'<br /></div></body></html>';

        if(enviaEmail(SUBJECT, $body, $email, $email)) {
            echo MENSAGEM_SUCESSO;
        } else {
            echo MENSAGEM_ERRO;
        }
    }   
}
?>