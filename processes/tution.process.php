<?php
session_start();
include'../includes/connect.inc.php';
$conn = connection('tms');

//var_dump($_GET['func']);
function save_logo($conn){
	//insert.php
	if($_FILES["file"]["name"] != ''){

		$tutionId = $_SESSION['tutionId'];
		$img = $_FILES['file']['name'];
		$extention = explode(".", $img);
		$extention = end($extention);
		$path = '../images/tution/'.$tutionId.'.'.$extention;
		move_uploaded_file($_FILES['file']['tmp_name'], $path);
		echo $path;
	}
	else{
		echo'File not Defined!!';
	}
}

function fetchTution($conn){
	$q = "SELECT * FROM tbl_tution WHERE tutionId LIKE '".$_POST['tutionId']."'";
	$result = mysqli_query($conn, $q);
	if (isset($result)) {
		$tution = mysqli_fetch_array($result);
	}
	else{
		echo '<span class="text-center alert alert-danger" style="position:absolute;top:50%;right:50%;">Oops!, Something went wrong.</span>';
	}
}


$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);

?>