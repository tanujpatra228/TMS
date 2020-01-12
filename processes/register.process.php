<?php
require'../includes/connect.inc.php';
$conn = connection('tms');

$tutionId = 'T'. mt_rand(1000000,9999999);
$branchId = $tutionId.'#1';

# Tution data
	$class_name = $_POST['class_name'];
	$class_tagline = $_POST['class_tagline'];
	$course = '';
	foreach ($_POST['course'] as $value) {
		if ($course == '') {
			$course .= $value;
		}else{
			$course .= ':'.$value;
		}
	}
	$class_address = $_POST['class_address'];
	$class_state = $_POST['class_state'];
	$class_city = $_POST['class_city'];
	$class_email = $_POST['class_email'];
	$class_phn = $_POST['class_phn'];
	$class_website = $_POST['class_website'];

	$q = "INSERT INTO tbl_tution(tutionId,name,tag_line,address,state,city,email,phone,url,course) VALUES('".$tutionId."','".$class_name."','".$class_tagline."','".$class_address."','".$class_state."','".$class_city."','".$class_email."','".$class_phn."','".$class_website."','".$course."');";
	$result = mysqli_query($conn, $q);

	if (!$result) {
		//mysqli_close($conn);
		//echo'Error!! Can\'t insert Tution data.';
		die(mysqli_error($conn));
	}else{
		echo 1;
	}

	$q = "INSERT INTO tbl_branch(branchId,tutionId,address,state,city,phone) VALUES('".$branchId."','".$tutionId."','".$class_address."',(SELECT stateName FROM `world_db`.`states` WHERE stateID = ".$class_state."), (SELECT cityName FROM `world_db`.`cities` WHERE stateID = ".$class_state." AND cityName like '".$class_city."' ),".$class_phn.");";
	$result = mysqli_query($conn, $q);
	if (!$result) {
		//mysqli_close($conn);
		echo'Error!! Can\'t insert Main Branch data.';
		die(mysqli_error($conn));
	}else{
		echo 2;
	}
#--------------------------------------------------------------------------------------------------------

# Admin data
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$pwd = $_POST['pwd'];
	$pwd = password_hash($pwd, PASSWORD_DEFAULT);

	$q = "SELECT MAX(adminId) AS last FROM tbl_admin;";
	$result = mysqli_query($conn, $q);
	$num = mysqli_fetch_array($result);
	$adminId = $num['last'] + 1;

	$q_admin = "INSERT INTO tbl_admin(tutionId,fname,lname,email,phone,pwd) VALUES('".$tutionId."', '".$fname."', '".$lname."', '".$email."', '".$mobile."','".$pwd."');";
	$result_admin = mysqli_query($conn, $q_admin);
	
	if (!$result_admin) {
		//mysqli_close($conn);
		die(mysqli_error($conn));
	}else{
		echo 3;
	}
#--------------------------------------------------------------------------------------------------------

/*# Branch data
	if (isset($_POST['b_address']) && isset($_POST['b_state']) && isset($_POST['b_city']) && isset($_POST['b_phn'])) {

	$b_address = $_POST['b_address'];
	$b_state = $_POST['b_state'];
	$b_city = $_POST['b_city'];
	$b_phn = $_POST['b_phn'];

	$i = 0;
	foreach ($b_address as $address) {
		$num = explode("#", $branchId);
		$num[1] = $num[1] + 1;
		$branchId = $tutionId.'#'.$num[1];

		$q = "INSERT INTO tbl_branch(branchId,tutionId,address,state,city,phone) VALUES('".$branchId."','".$tutionId."','".mysqli_real_escape_string($conn, $address)."','".mysqli_real_escape_string($conn, $b_state[$i])."','".mysqli_real_escape_string($conn, $b_city[$i])."','".mysqli_real_escape_string($conn, $b_phn[$i])."');";
		$result = mysqli_query($conn, $q);

		if (!$result) {
			//mysqli_close($conn);
			echo'Error!! Can\'t insert Branche(s) data.<a href="../regi_form.php">Retry!</a>';
			die();
		}else{
			echo"Branch(s) Inserted";
		}
		$i = $i + 1;
	}
	}
#--------------------------------------------------------------------------------------------------------
*/
mysqli_close($conn);
/*sleep(3000);
header("Location: ../login_admin.html");*/
?>