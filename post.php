<?php
	include 'config/config.php';

	if (isset($_POST['user']) && isset($_POST['message']), && isset($_POST['conversation'])) {
		if ($_POST['user'] != 'guest') {
			$conversation = $_POST['conversation'];
			$query = $db->prepare("INSERT INTO conversation_" . $conversation . " (user, message, time) VALUES ('" . $_POST['user'] . "', '" . $_POST['message'] . "', '" . time() . "')");
			$query->execute();
		}
	}
?>