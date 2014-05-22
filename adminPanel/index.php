<?php include 'includes/header.php'; ?>


<?php

switch (@$_GET['p']) {
	case 'inserir':
		include 'inserirRoteiro.php';
		break;

	default:
		include 'inserirRoteiro.php';
		break;
}

?>



<?php include 'includes/footer.php'; ?>