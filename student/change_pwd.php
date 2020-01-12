<?php
session_start();

include'../includes/connect.inc.php';
$conn = connection('tms');
//include'../fsins.php';

$studentId = $_SESSION['studentId'];
//$otp = mt_rand(1111,9999);
if (isset($_POST['submit'])) {

	$pwd = $_POST['pwd'];
	$new_pwd = $_POST['new_pwd'];

	echo$q = "SELECT * FROM tbl_student WHERE studentId LIKE '$studentId'";
	$student = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));
	echo$hashedPwd = password_verify($pwd, $student['password']);

	if ($hashedPwd == false) {
		mysqli_close($conn);
		die(mysqli_error($conn));
		header("Location: ../login_stud.php?invalid=true");
	}
	elseif ($hashedPwd == true) {
		$new_pwd =  password_hash($new_pwd,PASSWORD_DEFAULT);
		$q = "UPDATE tbl_student SET tbl_student.password = '$new_pwd' WHERE studentId LIKE '$studentId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		if ($result > 0) {
			echo'<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>';
			echo'<script type="text/javascript" src="../js/sweetalert.min.js"></script>';
			echo'<script type="text/javascript">
				$(function(){
					swal("Done","Password Changed Successfully","success");
					});
			</script>';

			sleep(3000);
			header("Location: ../processes/logout.process.php");
		}
	}
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.0.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
	<style type="text/css">
		.card{
			height: 450px;
			width: 500px;
			margin: auto;
		}
		.card input{
			width: 90%;
			height: 50px;
			margin: 20px 15px 15px 0px;
		}
	</style>
</head>
<body style="background-color: #ededed;">
	<div class="container mt-5">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="card text-center">
					<form action="#" method="POST" name="change_pwd">
						<input type="password" name="pwd" />
						<input type="password" name="new_pwd" />
						<input type="submit" name="submit" value="submit" />
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>