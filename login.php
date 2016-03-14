<?php

	if (isset($_POST['username'])) {
		setcookie('username', $_POST['username'], time()+3600*24*365);
		echo 'true';
	}

	if (isset($_POST['logout'])) {
		setcookie ('username', '', time()-1);
	}
	
?>