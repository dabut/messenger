<?php

	include '/../config/config.php';

	function isGuest() {
		global $user;
		if ($user == 'guest') {
			return 'true';
		} else {
			return 'false';
		}
	}

	if (isset($_COOKIE['username'])) {
		$user = $_COOKIE['username'];
	}

	if (!isset($user)) {
		$user = 'guest';
	}

	$user = addslashes($user);

	// if (isGuest()) {
	// 	$_GET['id'] = 0;
	// }
?>