<?php
	include 'config/config.php';

	if (isset($_GET['id'])&&isset($_GET['last_id'])) {
		$query = mysqli_query($db, "SELECT * FROM conversation_".$_GET['id']." WHERE id > ".$_GET['last_id']."");
		$result = array();
		$last_id = $_GET['last_id'];
		$count = 0;
		while ($row = mysqli_fetch_array($query)) {
			$row['user'] = htmlspecialchars($row['user']);
			$row['message'] = htmlspecialchars($row['message']);
			$result += array($count++ => $row);
			$last_id = $row['id'];
		}
		$output = array($result, 'last_id' => $last_id);
		echo json_encode($output);
	}
?>