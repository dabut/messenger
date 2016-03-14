<?php
	include 'assets/global.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = 0;;
	}

	$query = mysqli_query($db, "SELECT * FROM conversations WHERE id='".$id."'");
	if (!(mysqli_num_rows($query)>0)) {
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
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<script type="text/javascript" src="assets/jquery.js"></script>
		<script type="text/javascript" src="assets/script.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="menu">
			<a id="logout">Logout</a>
			</div>
			<div class="content">
				<div class="messages">

				</div>
			</div>
			<div class="input-group input">
				<input type="text" class="form-control" id="message_input" />
			</div>
		</div>
		<script>

			if (<?=isGuest()?>) {
				$('.messages').hide();
				$('#message_input').attr('id', 'login');
				$('#login').attr('placeholder', 'Username');
			}

			var username = '<?=$user?>';

			$('input').on('keypress', function(e){
				if (e.which == 13) {
					if ($(this).is('#login')) {
						if ($('#login').val() != '') {
							$.post('login.php', {username: $('#login').val()}, function(data){
								if (data == 'true') {
									username = $('#login').val();
									$('#login').val('');
									$('.messages').show();
									$('#login').attr('placeholder', '');
									$('#login').attr('id', 'message_input');
									last_id = 0;
								}
							});
						}
					} else if ($(this).is('#message_input')) {
						if ($('#message_input').val() != '') {
							$.post('send.php', {user: username, message: $('#message_input').val(), conversation: <?=$id?>});
							$('#message_input').val('');
						}
					}
				}
			});

			$('#logout').click(function(){
				$.post('login.php', {logout: true});
				username = 'guest';
				$('.messages').hide();
				$('#message_input').attr('id', 'login');
				$('#login').attr('placeholder', 'Username');
			});

			var last_id = 0;
			setInterval(function(){
				$.get('update.php?id=<?=$id?>&last_id='+last_id, function(data){ 
					var messages = JSON.parse(data)[0];
					last_id = JSON.parse(data)['last_id'];
					for (var i=0;i<messages.length;i++) {
						$('.messages').append(show(messages[i]['user'], messages[i]['time'], messages[i]['message']));
					}
					if (messages != '') {
						$('.messages').scrollTop($('.messages')[0].scrollHeight);
					}
				});
			}, 100);

			$(document).on('keypress', function(e){
				if (e.which == 13) {
				}
			});
		</script>
	</body>
</html>