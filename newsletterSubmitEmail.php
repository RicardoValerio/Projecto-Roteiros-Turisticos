<?php

@$email = mysql_real_escape_string($_POST['subscrever']);

$sql = "INSERT INTO newsletter (email) VALUES ('$email')";

mysql_query($sql);

?>