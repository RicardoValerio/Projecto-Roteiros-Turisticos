<?php
session_start();
require_once 'includes/config.php';

$post = (isset($_SESSION['url'])) ? mysql_real_escape_string($_SESSION['url']) : 'index.php';
if(!strlen(trim($post))) $post = 'index.php';

session_unset();
session_destroy();

header("Location: $post");
exit();
?>