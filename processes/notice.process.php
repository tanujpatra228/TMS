<?php

include'../includes/connect.inc.php';
$conn = connection('tms');

# INESRT NOTICE from dashboard.php --> ADMIN
	function ins_notice($conn){
		$tutionId = $_POST['tutionId'];
		$notice_head = mysqli_real_escape_string($conn, $_POST['notice_head']);
		$notice_body = mysqli_real_escape_string($conn, $_POST['notice_body']);
		$to = $_POST['recepient'];
		$date = $_POST['date'];
		$time = $_POST['time'];

		if (empty($notice_body)) {
			echo 'empty';
		}
		else{
			if (empty($notice_head)) {
				$notice_head = 'NOTICE';
			}
			$q = "INSERT INTO tbl_notice(tutionId,notice_head,notice_body,receipient,`date`,`time`) VALUES('".$tutionId."','".$notice_head."','".$notice_body."','".$to."','".$date."','".$time."')";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			if ($result) {
				echo 1;
			}
		}
	}
#--------------------------------------------------------------------------------

# FETCH NOTICE from dashboard.php --> STAFF "and" student(index.php)
	function fetch_notice($conn){
		$tutionId = $_POST['tutionId'];

		if ($_POST['type'] == 'student') {
			$q = "SELECT * FROM tbl_notice WHERE tutionId LIKE '".$tutionId."' AND receipient IN('student','all') ORDER BY time DESC LIMIT 1;";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			if ($result) {
				$notice = mysqli_fetch_array($result);
				if (empty($notice['notice_head']) && empty($notice['notice_body'])) {
					echo 0;
				}
				else{
					echo '<h4 class="alert-heading">'.$notice['notice_head'].'</h4><p>'.$notice['notice_body'].'</p><hr>
              <p class="mb-0 text-right" style="font-size: 13px;line-height: 1;">'.$notice['date'].'<br/><small>'.$notice['time'].'</small></p>';
				}
			}
			else{
				echo 0;
			}	
		}
		else{

			$q = "SELECT * FROM tbl_notice WHERE tutionId LIKE '".$tutionId."' AND receipient IN('staff','all') ORDER BY time DESC LIMIT 1;";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			if ($result) {
				$notice = mysqli_fetch_array($result);
				if (empty($notice['notice_head']) && empty($notice['notice_body'])) {
					echo 0;
				}
				else{
					echo '<h4 class="alert-heading">'.$notice['notice_head'].'</h4><p>'.$notice['notice_body'].'</p>';
				}
			}
			else{
				echo 0;
			}
		}
	}
#--------------------------------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);
?>