<?php
	include 'assets/global.php';

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		$id = 0;
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

			var conversation = '<?=$id?>';
		</script>
	</body>
</html>