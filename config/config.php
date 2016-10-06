<?php

	$config = json_decode(file_get_contents('config/config.json'), true);

	$db_host = $config['host'];
	$db_name = $config['name'];
	$db_user = $config['user'];
	$db_pass = $config['pass'];

	$db = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';', $db_user, $db_pass);

?>