<?php
session_start();
//$_SESSION['tutionId'];
include'../includes/connect.inc.php';
$conn = connection('tms');
$world_con = connection('world_db');

$q = "SELECT * FROM tbl_tution WHERE tutionId LIKE '".$_SESSION['tutionId']."'";
$tution = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

$tution['logo'];
$tution['name'];
$tution['tag_line'];
$tution['address'];
$tution['state'];
$tution['city'];
$tution['email'];
$tution['phone'];
$tution['url'];


$q = "SELECT stateName from states WHERE stateID LIKE '".$tution['state']."'";
$state = mysqli_fetch_array(mysqli_query($world_con, $q)) or die(mysqli_error($world_con));

mysqli_close($conn);
mysqli_close($world_con);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Contact Us | TMS</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet"> -->

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

	<link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
	<link rel="stylesheet" href="css/animate.css">
	
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">

	<link rel="stylesheet" href="css/aos.css">

	<link rel="stylesheet" href="css/ionicons.min.css">

	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="css/jquery.timepicker.css">

	
	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/style.css">
	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
</head>
<body>
	<?php 
		include 'header.php'; 
	?>

<div class="container" style="padding-left: 50px; margin-top: 100px;">
	<img src="../images/tution/<?php echo $tution['logo']; ?>" style="height: 100px; width: 100px;"> <br>
	<p> <?php echo $tution['name']; ?> </p>
	<p> <?php echo $tution['tag_line']; ?> </p>
	<p> <?php echo $tution['address']; ?> </p>
	<p> <?php echo $state['stateName']; ?> </p>
	<p> <?php echo $tution['city']; ?> </p>
	<p> <?php echo $tution['email']; ?> </p>
	<p> <?php echo $tution['phone']; ?> </p>
	<p> <?php echo $tution['url']; ?> </p>
</div>
	<?php
		include 'footerstud.php';
	?>


	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-migrate-3.0.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.stellar.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/aos.js"></script>
	<script src="js/jquery.animateNumber.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/jquery.timepicker.min.js"></script>
	<script src="js/scrollax.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
	<script src="js/google-map.js"></script>
	<script src="js/main.js"></script>
</body>	
</html>