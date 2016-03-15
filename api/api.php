<?php
	
	include '../config/config.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$request = $method . '/' . implode('/', array_filter(explode('/', $_REQUEST['request'])));
	$response = array('');
	switch ($request) {
		case 'GET/conversation':
			if (isset($_REQUEST['code'])) {
				$code = $_REQUEST['code'];
				$query = mysqli_query($db, "SELECT * FROM conversations WHERE code = '" . $code . "'");
				$conversation = '0';
				while ($row = mysqli_fetch_array($query)) {
					$conversation = $row['id'];
				}
				$response = array($conversation);
			}
			break;
		case 'POST/message':
			break;
	}
	echo json_encode($response);
?>