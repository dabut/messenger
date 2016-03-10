<?php
	include 'config/config.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
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
		$id = 0;;
	}

	if (!isset($conversation)) {
		$conversation = array();
	}
?>

<html>
	<head>
		<script type="text/javascript" src="assets/jquery.js"></script>
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
			var last_id = <?=$last_id?>;
			setInterval(function(){
				$.get('update.php?id=<?=$id?>&last_id='+last_id, function(data){
					$('.conversation').append(data[0]);
					last_id = data['last_id'];
					console.log(data);
				});
			}, 100);
		</script>
	</body>
</html>