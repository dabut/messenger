<?php
	
	include '../config/config.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$request = $method . '/' . implode('/', array_filter(explode('/', $_REQUEST['request'])));
	$response = array();
	switch ($request) {
		case 'GET/message':
			if (isset($_REQUEST['message'])) {
				$conversation = $_REQUEST['message'];
			}
			break;
		case 'POST/message':
			break;
	}
	echo json_encode($response);
?>