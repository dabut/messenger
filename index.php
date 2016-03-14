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
		<script type="text/javascript" src="assets/jquery.js"></script>
		<script type="text/javascript" src="assets/script.js"></script>
	</head>
	<body>
		<div class="container-fluid container">
			<div class="content">

			</div>
			<div class="input-group input">
				<input type="text" class="form-control" id="message_input" />
			</div>
		</div>
		<script>

			if (<?=isGuest()?>) {
				var oldContainer = $('.container').html();
				$('.container').html('<input type="text" id="login" placeholder="username" />');
			}
			var username = '<?=$user?>';

			$('#login').keypress(function(e){
				if (e.which == 13) {
					if ($('#login').val() != '') {
						$.post('login.php', {username: $('#login').val()}, function(data){
							if (data == 'true') {
								$('.container').html(oldContainer);
								last_id = 0;
							}
						});
					}
				}
			});

			var last_id = 0;
			setInterval(function(){
				$.get('update.php?id=<?=$id?>&last_id='+last_id, function(data){ 
					var messages = JSON.parse(data)[0];
					last_id = JSON.parse(data)['last_id'];
					for (var i=0;i<messages.length;i++) {
						$('.content').append(show(messages[i]['user'], messages[i]['time'], messages[i]['message']));
					}
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