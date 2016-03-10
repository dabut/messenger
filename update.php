<?php
	include 'config/config.php';

	if (isset($_POST['id'])&&isset($_POST['last_id'])) {
		$query = mysqli_query($db, "SELECT * FROM conversation_".$_POST['id']." WHERE id > ".$_POST['last_id']."");
		echo '{';
		while ($row = mysqli_fetch_array($query)) {
			echo '<div class="message_name">' . $message['user'] . '</div><div class="message_time">' . $message['time'] . '</div><div class="message_message">' . $message['message'] . '</div>,';
			$last_id = $id; 
		}
		echo '\'\', last_id: ' . $last_id . '}';
	}
?>