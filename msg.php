<?php

	if (isset($_GET['code'])) {
		$code = $_GET['code'];
		$conversation = file_get_contents('http://127.0.0.1/projects/messenger/api/conversation?code=' . $code);
		$id = json_decode($conversation, true)[0];
		$_GET['id'] = $id;
		include 'index.php';
	}
?>