<?php
	include 'config/config.php';

	if (isset($_GET['id'])) {
		$query = mysqli_query($db, "SELECT * FROM conversations WHERE id='".$_GET['id']."'");
		if (mysqli_num_rows($query)>0) {
			$query = mysqli_query($db, "SELECT * FROM conversation_".$_GET."");
			if (mysqli_num_rows($query)>0) {
				$conversation = array();
				while ($row = mysqli_fetch_array($query)) {
					$conversation += array($row['id'] => array('user' => $row['user'], 'time' => $row['time'], 'message' => $row['message']));
				}
			}
		}
	} else {

	}

	if (!isset($conversation)) {
		$conversation = array();
	}
?>

<html>
	<head>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<?php
					$last_id = 0;
					foreach ($conversation as $id => $message) {
						echo '<div class="message"><div class="message_name">' . $message['user'] . '</div><div class="message_time">' . $message['time'] . '</div><div class="message_message">' . $message['message'] . '</div></div>';
						$last_id = $id;
					}
				?>
			</div>
		</div>
		<script>
			setInterval(function(){
				
			}, 100);
		</script>
	</body>
</html>