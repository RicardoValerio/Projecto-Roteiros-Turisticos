<?php
	session_start();

	if(!isset($_SESSION["nome"]) && !isset($_SESSION["tipo_utilizador"])) {
		header("Location: ../index.php ");
		exit;
	}
?>