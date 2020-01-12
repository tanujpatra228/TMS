<?php
$update_result = '';
$student_id = preg_split("/[-|:]/",$_GET['profile']);	// Converting ID

$studentId = $student_id[0].'#'.$student_id[1].'#'.$student_id[2];	// Generating id
$student_photo = $student_id[0].'_'.$student_id[1].'_'.$student_id[2];	// Generating photo name
include '../includes/connect.inc.php';
$conn = connection('epiz_23787909_tms');


# Fetching Old Profile photo
	$q = "SELECT photo FROM tbl_student WHERE studentId LIKE '".$studentId."'";
	$old_photo = mysqli_query($conn, $q) or die("Can't execute query!");
	if (mysqli_num_rows($old_photo) == 1) {
		$old_photo = mysqli_fetch_array($old_photo);
		$display = '../images/student/'.$old_photo['photo'];
	}else{
		$display = '../images/default_avatar_0.png';
	}
#----------------------------------------------------------------------------


# =================== UPDATING USER DATA ====================================
if (isset($_POST['student_save'])) {
	# Profile photo update
	if (isset($_FILES['s_image'])) {
		$photo = $_FILES['s_image']['name'];
		$extention = explode(".", $photo);

		if (file_exists("../images/student/".$old_photo['photo'])) {
			@unlink("../images/student/".$old_photo['photo']);
		}
		move_uploaded_file($_FILES['s_image']['tmp_name'], "../images/student/".$student_photo.'.'.$extention[1]);

		$old_photo['photo'] = $student_photo.'.'.$extention[1];
	}

	$new_fname = mysqli_real_escape_string($conn, $_POST['f_name']);
	$new_photo = $old_photo['photo'];
	$new_father_name = mysqli_real_escape_string($conn, $_POST['s_father_name']);
	$new_mother_name = mysqli_real_escape_string($conn, $_POST['s_mother_name']);
	$new_lname = mysqli_real_escape_string($conn, $_POST['l_name']);
	$new_sex = mysqli_real_escape_string($conn, $_POST['s_sex']);
	$new_std = mysqli_real_escape_string($conn, $_POST['s_std']);
	$new_branch = mysqli_real_escape_string($conn, $_POST['s_branch']);
	$new_phn = mysqli_real_escape_string($conn, $_POST['s_phn']);
	$new_email = mysqli_real_escape_string($conn, $_POST['s_email']);
	$new_totalFees = mysqli_real_escape_string($conn, $_POST['s_totalFees']);;
	$new_dob = mysqli_real_escape_string($conn, $_POST['s_dob']);;
	$new_address = mysqli_real_escape_string($conn, $_POST['s_address']);
	$new_state = mysqli_real_escape_string($conn, $_POST['s_state']);
	$new_city = mysqli_real_escape_string($conn, $_POST['s_city']);
	
	$q = "UPDATE `tbl_student` SET `photo` = '".$new_photo."', `name` = '".$new_fname.' '.$new_lname."', `fatherName` = '".$new_father_name."', `motherName` = '".$new_mother_name."', `sex` = '".$new_sex."', `branchId` = '".$new_branch."', `phone` = '".$new_phn."', `email` = '".$new_email."', `std` = '".$new_std."', `totalFees` = '".$new_totalFees."', `dob` = '".$new_dob."', `address` = '".$new_address."', `state` = '".$new_state."', `city` = '".$new_city."' WHERE `tbl_student`.`studentId` = '".$studentId."';";

	$update_result = mysqli_query($conn ,$q) or die(mysqli_error($conn));

	if ($update_result > 0) {
		echo "<script>alert('student data updated');</script>";
		echo'<script type="text/javascript" src="../js/sweetalert.min.js"></script>';
		echo'<script>swal("Done", student data updated,"seccess");</script>';
	}
	else{
		echo'<script type="text/javascript" src="../js/sweetalert.min.js"></script>';
		echo'<script>swal("Hmm!", '.mysqli_error($conn).',"error");</script>';
	}
}
# ===========================================================================

# Fetching Current Profile photo
	$q = "SELECT photo FROM tbl_student WHERE studentId LIKE '".$studentId."'";
	$current_photo = mysqli_query($conn, $q) or die("Can't execute query!");
	if (mysqli_num_rows($current_photo) == 1) {
		$current_photo = mysqli_fetch_array($current_photo);
		$display = '../images/student/'.$current_photo['photo'];
	}else{
		$display = '../images/default_avatar_0.png';
	}
#----------------------------------------------------------------------------
# Fetching USER DATA
	$q = "SELECT * FROM tbl_student WHERE studentId LIKE '".$studentId."'";
	$result = mysqli_query($conn, $q) or die("Can't execute query!");
	$student = mysqli_fetch_array($result);

	# student data
	$student_tution = $student['tutionId'];
	$student_branch = $student['branchId'];
	$name = preg_split("/ /", $student['name']);
	$fname = $name[0];
	$lname = '';if (isset($name[1])){$lname = $name[1];}
	$fathername = $student['fatherName'];
	$mothername = $student['motherName'];
	//$photo = $student['photo'];
	$sex = $student['sex'];
	$phn = $student['phone'];
	$email = $student['email'];
	$std = $student['std'];
	$totalFees = $student['totalFees'];
	$paidFees = $student['paidFees'];
	$address = $student['address'];
	$state = $student['state'];
	$city = $student['city'];
	//$type = $student['type'];
	# \.student data

	# fetch branch
		$branch_q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '".$student['tutionId']."'";
		$branches = mysqli_query($conn, $branch_q);
	# \.fetch branch
#---------------------------------------------------------------------------------------------

		$q = "SELECT course FROM tbl_tution WHERE tutionId LIKE '".$student['tutionId']."'";
		$result = mysqli_query($conn, $q);
		$r = mysqli_fetch_array($result);
		$courses = preg_split("/:/",$r['course']);
		
		$in = "IN (";
		foreach ($courses as $course) {
			if ($in == 'IN ('){
				$in .= "'$course'";
			}
			else{
				$in .= ",'$course'";
			}
		}
		$in .= ")";
		
		$q = "SELECT * FROM tbl_course WHERE short_name ".$in;
		$all_std = mysqli_query($conn, $q);

		/*if (isset($_REQUEST['calling_func'])){
			foreach ($all_std as $course) {
				echo '<option value="'.$course['short_name'].'" style="color:#111;">'.$course['name'].'</option>';
			}
		}*/

	mysqli_close($conn) or die('can not close connection to tms');

	# States , Cities
		$conn = connection('world_db');
		$q = 'SELECT stateID,stateName FROM states s, countries c WHERE c.countryID = s.countryID AND c.countryID LIKE "IND" ORDER BY stateName';
		$result_world = mysqli_query($conn,$q);
	mysqli_close($conn) or die('can not close connection to worldDb');
#--------------------------------------------------------


?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Student Profile</title>
	
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	
	<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		
	<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	
	<style type="text/css" rel="stylesheet" >
		.container
		{
			margin-top:40px;
			padding:20px;
		}
		#img_box
		{
			background-image: url("<?php echo $display; ?>");
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			background-color:#ddd;
			height:150px; 
			width:150px;
		}
		#exit
		{
				width:140px;
		}
	
	</style>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>

	<script type="text/javascript" src="../js/fetch_location.js"></script>
<?php
if (isset($_POST['satff_save'])) {
	
	if ($update_result == 1) {
		echo'<script>
			$(document).ready(function(){
				swal({
					title: "Done",
					text: "'.$update_result.', record(s) Updated!",
					icon: "success",
					buttons: true,
				});
			});
			</script>';
	}
	else{
		echo'<script>
			$(document).ready(function(){
				swal({
					title: "Failed!",
					text: "Can not update,",
					icon: "danger",
					buttons: true,
				});
			});
			</script>';
	}
}
?>
	<script type="text/javascript">
		$(function(){
			$('#img_box').click(function(){
				$('#s_image').click();
					console.log($('#s_image').val());
			});
			$('#exit').click(function(){
				self.close();
			});
		});
		function readURL(input) {
					if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#img_box')
							.css({'background-image':'url('+e.target.result+')'});
					};

					reader.readAsDataURL(input.files[0]);
				}
			}

		function setDob(){
			if ($('#s_dob').attr('value') == '') {
				var date = new Date();
				if (date.getMonth() < 10) {month = '0'+date.getMonth();}
				if (date.getDate() < 10) {day = '0'+date.getDate();}
				date = date.getFullYear()+'-'+month+'-'+day;
				$('#s_dob').attr('value',date);
				//alert($('#s_dob').attr('value'));
			}
		}
	</script>
</head>
<body>
	<div class="container">
		<form name="student_update_form" id="student_update_form" action="#" method="POST" enctype="multipart/form-data" onsubmit="setDob();">
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<div id="img_box" class="rounded float-right border"></div>
						<input type="file" accept="image/*" name="s_image" class="s_image input" id="s_image" style="display:none;" onchange="readURL(this);" value="<?php echo $current_photo; ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="f_name">Student Details:</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<input type="text" placeholder="First Name" name="f_name" class="f_name input form-control" id="f_name" value="<?php echo $fname; ?>" />
					</div>
					
					<div class="col-md-4">
						<input type="text" placeholder="Last Name" name="l_name" class="l_name input form-control" id="l_name" value="<?php echo$lname; ?>" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<?php if($sex == 'male'){ ?>
						<select name="s_sex" id="s_sex" class="s_sex input form-control">
							<option value="male" selected>Male</option>
							<option value="female">Female</option>
						</select>
						<?php }else{ ?>
						<select name="s_sex" id="s_sex" class="s_sex input form-control">
							<option value="female" selected>Female</option>
							<option value="male">Male</option>
						</select>
						<?php } ?>
					</div>
					<div class="col-md-6">
						<select name="s_std" id="s_std" class="s_std input form-control">
							<option disabled>STD</option>
							<?php
								foreach ($all_std as $course) {
									if ($course['short_name'] == $std) {
										echo '<option value="'.$course['short_name'].'" selected>'.$course['name'].'</option>';
									}
									else{
									echo '<option value="'.$course['short_name'].'">'.$course['name'].'</option>';
									}
								}
							?>
						</select>
					</div>
					
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="s_branch" id="s_branch" class="s_branch input form-control">
						<?php 
							foreach ($branches as $branch) {
								if ($branch['branchId'] == $student_branch) {	
									echo'<option value="'.$branch['branchId'].'" selected>'.$branch['address'].'</option>';
								}
								else{
									echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
								}
							}
						?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="f_name">Parential Details:</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="text" placeholder="Father Name" name="s_father_name" class="s_father_name input form-control" id="s_father_name" value="<?php echo $fathername; ?>" />
					</div>
					<div class="col-md-6">
						<input type="text" placeholder="Mother Name" name="s_mother_name" class="s_mother_name input form-control" id="s_mother_name" value="<?php echo $mothername; ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="f_name">Contact Details:</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<input type="tel" placeholder="Phone No."name="s_phn" class="s_phn input form-control" id="s_phn" value="<?php echo $phn; ?>" />
					</div>
					<div class="col-md-6">
						<input type="email" placeholder="Email-Id" name="s_email" class="s_email input form-control" id="s1_email" value="<?php echo $email; ?>" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="s_address">Address Details:</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<textarea placeholder="Address" name="s_address" class="s_address input form-control" id="s_address" rows="3" value="<?php echo $address; ?>"></textarea>
					</div>
					<div class="col-md-6">
						<label for="s_totalFees" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Total Fees</label><input type="text" class="s_totalFees input form-control" id="s_totalFees" name="s_totalFees" value="<?php echo $totalFees; ?>" style="margin-bottom: 4px;width: 200px;display: inline-block;text-align: right;"/>

						<label for="s_paidFees" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Paid Fees</label><input type="text" class="s_paidFees input form-control" id="s_paidFees" name="s_paidFees" value="<?php echo $paidFees; ?>" style="margin-bottom: 4px;width: 200px;display: inline-block;text-align: right;"/>

						<label for="s_dob" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Date of Joining</label><input type="date" class="s_dob input form-control" id="s_dob" name="s_dob" value="<?php echo $doj; ?>" style="width: 200px;display: inline-block;"/>
					</div>
				</div>
			</div>	
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="s_state" id="s_state" class="s_state input form-control" onchange="fetchCities(this.value,'s_city');">
							<option disabled selected value="0">State</option>
						<?php 
						foreach ($result_world as $r){
							if ($student['state'] == $r['stateID']){
								echo '<option value="'.$r['stateID'].'" style="color:#111;" selected>'.$r['stateName'].'</option>';
							}else{
							echo '<option value="'.$r['stateID'].'" style="color:#111;">'.$r['stateName'].'</option>';
							}
						}
						?>
						</select>
						<span class="text-danger" id="error-s_state"></span>
					</div>
					<div class="col-md-6">
						<select name="s_city" id="s_city" class="s_city input form-control">
							<?php
								if (isset($city)) {
									echo'<option selected value="'.$city.'">'.$city.'</option>';
								}else{
									echo'<option disabled selected value="0">City</option>';
								}
							?>
						</select>
					</div>
				</div>
			</div>	
			<div class="form-group">
				<div class="row">
					<div class="col-md-12 text-center">
						<button type="submit" id="student_save" name="student_save" class="btn btn-outline-success btn-lg">Save</button>
						
						<button type="button" id="exit" class="btn btn-outline-danger btn-lg">Exit</button>
					</div>
				</div>
			</div>	
		</form>
	
	</div>
</body>
</html>

