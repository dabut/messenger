<?php
	include 'config/config.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = 0;;
	}

	$query = mysqli_query($db, "SELECT * FROM conversations WHERE id='".$id."'");
	if (mysqli_num_rows($query)>0) {
		$query = mysqli_query($db, "SELECT * FROM conversation_".$id."");
		if (mysqli_num_rows($query)>0) {
			$conversation = array();
			while ($row = mysqli_fetch_array($query)) {
				$conversation += array($row['id'] => array('user' => $row['user'], 'time' => $row['time'], 'message' => $row['message']));
			}
		}
	} else {
		header('Location: index.php');
	}

	if (!isset($conversation)) {
		$conversation = array();
	}
?>

<html>
	<head>
		<script type="text/javascript" src="assets/jquery.js"></script>
		<script type="text/javascript" src="assets/script.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="content">

			</div>
		</div>
		<script>
			<?php
				$last_id = 0;
				foreach ($conversation as $this_id => $message) {
					echo '$(\'.content\').append(show(\'' . $message['user'] . '\', \'' . $message['time'] . '\', \'' . $message['message'] . '\'));';
					$last_id = $this_id;
				}
			?>
			var last_id = <?=$last_id?>;
			setInterval(function(){
				$.get('update.php?id=<?=$id?>&last_id='+last_id, function(data){ 
					var messages = JSON.parse(data)[0];
					for (var i=0;i<messages.length;i++) {
						$('.content').append(show(messages[i]['user'], messages[i]['time'], messages[i]['message']));
					}
					last_id = JSON.parse(data)['last_id'];
				});
			}, 100);
		</script>
	</body>
</html>