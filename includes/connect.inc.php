<?php

	$server = 'localhost';
	$user = 'root';		// blackban_tp
	$pwd = '';		//tanuj_228
	# $db = blackban_tms AND blackban_world_db

	function connection($db='tms'){
			# accessing global variables
		/*if (strcmp($db, 'tms') == 0) {
			$db = 'blackban_tms';
		}
		if (strcmp($db, 'world_db') == 0) {
			$db = 'blackban_world_db';
		}*/

		global $server,$user,$pwd;

		// $conn_obj = mysqli_connect($server,$user,$pwd,$db) or die('can not connect '.$server.' '.$user.' '.$pwd.' '.$db);
		$conn_obj = mysqli_connect($server,$user,$pwd,$db) OR die("can't connect! - ".mysqli_error($conn_obj));
		return $conn_obj;
	}
	//mysqli_close(connection('on&on_db'));
?>