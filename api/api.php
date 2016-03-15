<?php
	
	include '../config/config.php';

	$method = $_SERVER['REQUEST_METHOD'];
	$request = $method . '/' . explode('/', $_REQUEST['request'])[0];
	$additional = array_filter(explode('/', $_REQUEST['request']));
	$response = array('');
	switch ($request) {
		case 'GET/conversation':
			if (isset($additional[1])) {
				$code = $additional[1];
				$query = mysqli_query($db, "SELECT * FROM conversations WHERE code = '" . $code . "'");
				$conversation = '0';
				while ($row = mysqli_fetch_array($query)) {
					$conversation = $row['id'];
				}
				$response = array($conversation);
			} else {
				$response = array('0');
			}
			break;
		case 'POST/conversation':
			$characters = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i' ,'j', 'k', 'l', 'm', 'n' ,'o' ,'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

			function create($n, $set = '16') {

				global $characters;

				switch ($set) {
					case '16':
						$start = 0;
						$end = 15;
						break;
					case 'full':
						$start = 0;
						$end = 61;
						break;
					case 'lower':
						$start = 10;
						$end = 35;
						break;
					case 'upper':
						$start = 36;
						$end = 61;
						break;
					case 'num':
						$start = 0;
						$end = 9;
						break;
					default:
						$start = 0;
						$end = 61;
						break;

				}

				$d = $end - $start + 1;
				$offset = $start;

				$rand = mt_rand(0, $d**$n-1);
				$str = '';
				for ($i=0;$i<$n;$i++) {
					$str .= $characters[floor($rand / $d**$i) % $d + $offset];
				}
				return $str;
			}

			$rand = create(4, 'lower');

			do {
				$query = mysqli_query($db, "SELECT * FROM conversations WHERE code = '" . $rand . "'");
				echo mysqli_error($db);
				if (mysqli_num_rows($query) == 0) {
					$found = false;
					$query = mysqli_query($db, "INSERT INTO conversations (code) VALUES ('" . $rand . "')");
					$query = mysqli_query($db, "SELECT * FROM conversations WHERE code = '" . $rand . "'");
					while ($row = mysqli_fetch_array($query)) {
						$id = $row['id'];
					}
					$query = mysqli_query($db, "CREATE TABLE conversation_" . $id . " (id int(11) AUTO_INCREMENT PRIMARY KEY, user varchar(20) NOT NULL, time int(11) NOT NULL, message text NOT NULL)");
					$response = array($rand);
				} else {
					$found = true;
					$rand = create(4, 'lower');
				}
			} while ($found = false);
			break;
	}
	echo json_encode($response);
?>