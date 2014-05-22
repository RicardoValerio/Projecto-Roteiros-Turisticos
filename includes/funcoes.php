<?php
function verificaAreaExiste() {
	if(isset($_GET['area'])) {
		$area_escolhida = $_GET['area'];
	} else {
		$area_escolhida = 'inicio';
	}
	return $area_escolhida;
}

function verificaAreaIndex($elem) {
	$area_escolhida = verificaAreaExiste();

	switch ($area_escolhida){
		case 'destinos': {
			$tituloEscolhido = 'Destinos | '.NOME_EMPRESA;
			$areaEscolhida = 'area_categorias.php';
                        $bannerEscolhido = 'banner.php';
		} break;
		case 'o_que_procura': {
			$tituloEscolhido = 'O que procura? | '.NOME_EMPRESA;
			$areaEscolhida = 'area_pesquisa.php';
                        $bannerEscolhido = 'banner.php';
		} break;
		case 'noticias': {
			$tituloEscolhido = 'Notícias | '.NOME_EMPRESA;
			$areaEscolhida = 'area_noticias.php';
                        $bannerEscolhido = 'banner.php';
		} break;
		case 'galeria': {
			$tituloEscolhido = 'Galeria | '.NOME_EMPRESA;
			$areaEscolhida = 'area_galeria.php';
                        $bannerEscolhido = 'banner.php';
		} break;
		case 'termos_condicoes': {
			$tituloEscolhido = 'Termos e Condições | '.NOME_EMPRESA;
			$areaEscolhida = 'area_termos_condicoes.php';
                        $bannerEscolhido = 'banner.php';
		} break;
		case 'inicio':
                default: {
			$tituloEscolhido = NOME_EMPRESA;
			$areaEscolhida = 'area_home.php';
                        $bannerEscolhido = 'slideshow.php';
		} break;
	}
	
	switch ($elem){
		case 'titulo': {
			return $tituloEscolhido;
		} break;
		case 'linkNavegacao': {
			return $areaEscolhida;
		} break;
                case 'banner': {
                    return $bannerEscolhido;
                break;
                }
	}
}

function enviaEmail($subject,$body,$email_destinatario,$username_destinatario) {
	require_once 'phpMailer/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = 'smtp';
	$mail->SMTPAuth = true;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';
	$mail->Username = USERNAME_EMAIL;
	$mail->Password = PASSWORD_EMAIL;
	$mail->IsHTML(true);
	$mail->SingleTo = true;
	$mail->From = USERNAME_EMAIL;
	$mail->FromName = NOME_EMPRESA;
	$mail->addAddress($email_destinatario,$username_destinatario);	
	$mail->AddEmbeddedImage("img/logo_email.jpg","logo","img/logo_email.jpg");
	$mail->Subject = $subject;
	$mail->Body = $body;
	if(!$mail->Send()) {
		return false;
	} else {
		return true;
	}
}
?>