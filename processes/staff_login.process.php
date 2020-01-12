<?php 
session_start();

include'../includes/connect.inc.php';
$conn = connection('tms');
// password_verify($password, $r['password']);

# Data from login_form.php
$email = $_POST['email'];
$pwd = $_POST['pwd'];
#-----------------------------------------

$q = "SELECT * FROM tbl_staff WHERE email LIKE '".$email."';";
$result = mysqli_query($conn, $q);
$num = mysqli_num_rows($result);

if ($num < 1) {
	header("Location: ../login_teacher.php");
	exit();
}
else{
	if ($staff = mysqli_fetch_array($result)) {
		$hashedPwd = password_verify($pwd, $staff['password']);
		if ($hashedPwd == false) {
			header("Location: ../login_teacher.php?invalid=true");
		}
		elseif ($hashedPwd == true) {
			$_SESSION['tutionId'] = $staff['tutionId'];
			$_SESSION['staffId'] = $staff['staffId'];
			$_SESSION['name'] = $staff['name'];
			$_SESSION['type'] = 'staff';
			header("Location: ../admin/dashboard.php");
		}
	}
}
mysqli_close($conn);
?>