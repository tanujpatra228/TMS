<?php 
session_start();
include'../includes/connect.inc.php';
$conn = connection('tms');
// password_verify($password, $r['password']);

	# Data from login_form.php
	$id = $_POST['email'];
	$pwd = $_POST['pwd'];
	#-----------------------------------------

	$q = "SELECT * FROM tbl_student WHERE studentId LIKE '".$id."';";
	$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
	$num = mysqli_num_rows($result);

	if ($num < 1) {
		die(mysqli_error($conn));
		header("Location: ../login_stud.html");
		exit();
	}
	else{
		if ($student = mysqli_fetch_array($result)) {
			$hashedPwd = password_verify($pwd, $student['password']);
			if ($hashedPwd == false) {
				echo mysqli_error($conn);
				sleep(3000);
				header("Location: ../login_stud.php?invalid=true");
			}
			elseif ($hashedPwd == true) {
				$_SESSION['tutionId'] = $student['tutionId'];
				$_SESSION['branchId'] = $student['branchId'];
				$_SESSION['studentId'] = $student['studentId'];
				$_SESSION['name'] = $student['name'];
				$_SESSION['type'] = 'student';
				//die();
				header("Location: ../student/index.php");
			}
		}
	}
	mysqli_close($conn);
?>