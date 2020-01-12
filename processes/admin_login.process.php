<?php
session_start();
echo'<script>alert("process");</script>';
include '../includes/connect.inc.php';
$conn = connection('tms');

$email = $_POST['email'];
$pwd = $_POST['pwd'];

$q = "SELECT * FROM tbl_admin WHERE email LIKE '$email'";
$result = mysqli_query($conn, $q);
$num = mysqli_num_rows($result);

if ($num < 1) {
	header("Location: ../login_admin.php");
	exit();
}
else{
	if ($admin = mysqli_fetch_array($result)) {
		$hashedPwd = password_verify($pwd, $admin['pwd']);
		if ($hashedPwd == false) {
			header("Location: ../login_admin.php?invalid=true");
			exit();
		}
		elseif ($hashedPwd == true) {
			$_SESSION['tutionId'] = $admin['tutionId'];
			$_SESSION['adminId'] = $admin['adminId'];
			$_SESSION['fname'] = $admin['fname'];
			$_SESSION['lname'] = $admin['lname'];
			$_SESSION['type'] = 'admin';
			header("Location: ../admin/dashboard.php");
			exit();
		}
	}
}
?>