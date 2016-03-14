<?php
	include 'config/config.php';

	if (isset($_POST['user']) && isset($_POST['message']) && isset($_POST['conversation'])) {
		if ($_POST['user'] != 'guest' && $_POST['conversation'] != '0') {
			$conversation = $_POST['conversation'];
			$query = mysqli_query($db, "INSERT INTO conversation_" . $conversation . " (user, message, time) VALUES ('" . htmlspecialchars(addslashes($_POST['user'])) . "', '" . htmlspecialchars(addslashes($_POST['message'])) . "', '" . time() . "')");
		}
	}
?>