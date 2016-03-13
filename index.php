<?php
	include 'assets/global.php';

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
				$conversation += array($row['id'] => array('user' => addslashes($row['user']), 'time' => $row['time'], 'message' => addslashes($row['message'])));
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
		<link rel="stylesheet" type="text/css" href="assets/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="assets/style.css" />
		<script type="text/javascript" src="assets/jquery.js"></script>
		<script type="text/javascript" src="assets/script.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<div class="container content">

			</div>
			<div class="input-group">
				<input type="text" class="form-control" id="message_input" />
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

			if (<?=isGuest()?>) {
				var oldContainer = $('.container').html();
				$('.container').html('<p id="login">Login</p>');
			} else {
				console.log('false');
			}

			var username = '<?=$user?>';

			$('#login').click(function(){
				username = window.prompt('Pick a username');
				$.post('login.php', {username: username}, function(data){
					if (data == 'true') {
						$('.container').html(oldContainer);
					}
				});
			});

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

			$('#message_input').keypress(function(e){
				if (e.which == 13) {
					if ($('#message_input').val() != '') {
						$.post('send.php', {user: username, message: $('#message_input').val(), conversation: <?=$id?>});
						$('#message_input').val('');
					}
				}
			});
		</script>
	</body>
</html>