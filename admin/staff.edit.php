<?php
$update_result = '';
$_GET['profile'].'<br/>';
$staff_id = preg_split("/[-|:]/",$_GET['profile']);	// Converting ID

$staffId = $staff_id[0].'#'.$staff_id[1].'#'.$staff_id[2].':'.$staff_id[3];	// Generating id
$staff_photo = $staff_id[0].'_'.$staff_id[1].'_'.$staff_id[2].$staff_id[3];	// Generating photo id
include '../includes/connect.inc.php';
$conn =connection('epiz_23787909_tms');

# Fetching Old Profile photo
	$q = "SELECT photo FROM tbl_staff WHERE staffId LIKE '".$staffId."'";
	$old_photo = mysqli_query($conn, $q) or die("Can't execute query!");
	if (mysqli_num_rows($old_photo) == 1) {
		$old_photo = mysqli_fetch_array($old_photo);
		$display = '../images/staff/'.$old_photo['photo'];
	}else{
		$display = '../images/default_avatar_0.png';
	}
#----------------------------------------------------------------------------
# =================== UPDATING USER DATA ====================================
if (isset($_POST['satff_save']) ) {

	$new_fname = mysqli_real_escape_string($conn, $_POST['f_name']);
	$new_mname = mysqli_real_escape_string($conn, $_POST['m_name']);
	$new_lname = mysqli_real_escape_string($conn, $_POST['l_name']);
	$new_sex = mysqli_real_escape_string($conn, $_POST['s_sex']);
	$new_qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
	$new_branch = mysqli_real_escape_string($conn, $_POST['s_branch']);
	$new_phn = mysqli_real_escape_string($conn, $_POST['s_phn']);
	$new_email = mysqli_real_escape_string($conn, $_POST['s_email']);
	$new_totalSalary = mysqli_real_escape_string($conn, $_POST['s_totalSalary']);;
	$new_doj = mysqli_real_escape_string($conn, $_POST['s_doj']);;
	$new_address = mysqli_real_escape_string($conn, $_POST['s_address']);
	$new_state = mysqli_real_escape_string($conn, $_POST['s_state']);
	$new_city = mysqli_real_escape_string($conn, $_POST['s_city']);
	
	# Profile photo update
	if (isset($_FILES['s_image'])) {
		//print_r($_FILES['s_image']);
		$photo = $_FILES['s_image'];
		$extention = explode(".", $photo['name']);
		
		if (file_exists("../images/staff/".$old_photo['photo'])) {
			unlink("../images/staff/".$old_photo['photo']);
		}
		move_uploaded_file($photo['tmp_name'], "../images/staff/".$staff_photo.'.'.$extention[1]);
		
		$q = "UPDATE `tbl_staff` SET `photo` = '".$staff_photo.'.'.$extention[1]."', `name` = '".$new_fname.' '.$new_lname."', `middleName` = '".$new_mname."', `sex` = '".$new_sex."', `branchId` = '".$new_branch."', `phone` = '".$new_phn."', `email` = '".$new_email."', `qualification` = '".$new_qualification."', `totalSalary` = '".$new_totalSalary."', `doj` = '".$new_doj."', `address` = '".$new_address."', `state` = '".$new_state."', `city` = '".$new_city."' WHERE `tbl_staff`.`staffId` = '".$staffId."';";
	}
	else{
		$q = "UPDATE `tbl_staff` SET `name` = '".$new_fname.' '.$new_lname."', `middleName` = '".$new_mname."', `sex` = '".$new_sex."', `branchId` = '".$new_branch."', `phone` = '".$new_phn."', `email` = '".$new_email."', `qualification` = '".$new_qualification."', `totalSalary` = '".$new_totalSalary."', `doj` = '".$new_doj."', `address` = '".$new_address."', `state` = '".$new_state."', `city` = '".$new_city."' WHERE `tbl_staff`.`staffId` = '".$staffId."';";
	}

	$update_result = mysqli_query($conn ,$q);
}
# ===========================================================================
# Fetching Current Profile photo
	$q = "SELECT photo FROM tbl_staff WHERE staffId LIKE '".$staffId."'";
	$current_photo = mysqli_query($conn, $q) or die("Can't execute query!");
	if (mysqli_num_rows($current_photo) == 1) {
		$current_photo = mysqli_fetch_array($current_photo);
		$display = '../images/staff/'.$current_photo['photo'];
	}else{
		$display = '../images/default_avatar_0.png';
	}
#----------------------------------------------------------------------------
# Fetching USER DATA
	$q = "SELECT * FROM tbl_staff WHERE staffId LIKE '".$staffId."'";
	$result = mysqli_query($conn, $q) or die("Can't execute query!");
	$staff = mysqli_fetch_array($result);

	# staff data
	$staff_branch = $staff['branchId'];
	$name = preg_split("/ /", $staff['name']);
	$fname = $name[0];
	$lname = '';
	if (isset($name[1])){$lname = $name[1];}
	$mname = $staff['middleName'];
	$sex = $staff['sex'];
	$phn = $staff['phone'];
	$email = $staff['email'];
	$qualification = $staff['qualification'];
	$totalSalary = $staff['totalSalary'];
	$paidSalary = $staff['paidSalary'];
	$doj = $staff['doj'];
	$exp = $staff['exp'];
	$address = $staff['address'];
	$state = $staff['state'];
	$city = $staff['city'];
	$type = $staff['type'];
	# \.staff data

	# fetch branch
		$branch_q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '".$staff['tutionId']."'";
		$branches = mysqli_query($conn, $branch_q);
	# \.fetch branch

	mysqli_close($conn) or die('can not close connection to tms');

	# States , Cities
		$conn = connection('world_db');
		$q = 'SELECT stateID,stateName FROM states s, countries c WHERE c.countryID = s.countryID AND c.countryID LIKE "IND" ORDER BY stateName';
		$result = mysqli_query($conn,$q);
	mysqli_close($conn) or die('can not close connection to worldDb');
#--------------------------------------------------------
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Staff Profile</title>
	 <meta charset="UTF-8"> 

    <!-- jQuery CDN -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- \.jQuery CDN -->

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- \.Bootstrap CDN -->
	<script type="text/javascript" src="../js/sweetalert.min.js"></script>
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

	<style type="text/css" rel="stylesheet" >
		.container{
			margin-top:40px;
			padding:20px;
		}
		#img_box{
			background-image: url("<?php echo $display; ?>");
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			background-color:#ddd;
			height:150px; 
			width:150px;
		}
		#s_address{
			height: 130px;
		}
		#btn_save,#btn_exit{
				width:140px;
		}
		
	</style>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script type="text/javascript" src="../js/fetch_location.js"></script>
	<script type="text/javascript">

		function readURL(input) {
				if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#img_box').css({'background-image':'url('+ e.target.result+')'});
				};
				reader.readAsDataURL(input.files[0]);
			}
		}

		$(function(){
			$('#img_box').click(function(){
				$('#s_image').click();
					//console.log($('#s_image').val());
			});

			//$('#img_box').css("background-image":"url(../images/staff/T0000001_1_S1.jpg)");

			$('#btn_exit').click(function(){
				self.close();
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<form name="staff_update_form" id="staff_update_form" method="POST" action="#" enctype="multipart/form-data">

			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<div id="img_box" class="rounded float-right border"></div>
						<input type="file" accept="image/jpg, image/jpeg, image/png" name="s_image" class="s_image input" id="s_image" style="display:none;" onchange="readURL(this);"/>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="f_name">Personal Details:</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<input type="text" placeholder="First Name" name="f_name" class="f_name input form-control" id="f_name" value="<?php echo $fname; ?>" />
					</div>
					<div class="col-md-4">
						<input type="text" placeholder="Middle Name" name="m_name" class="m_name input form-control" id="m_name" value="<?php echo $mname; ?>">
					</div>
					<div class="col-md-4">
						<input type="text" placeholder="Last Name" name="l_name" class="l_name input form-control" id="l_name" value="<?php echo $lname; ?>" />
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
						<input type="text" placeholder="Qualification" name="qualification" class="qualification input form-control" id="qualification">
					</div>	
				</div>
			</div>
			
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
							<?php 
								echo'<select name="s_branch" id="s_branch" class="s_branch input form-control">';
							foreach ($branches as $branch) {
								if ($branch['branchId'] == $staff_branch) {	
									echo'<option value="'.$branch['branchId'].'" selected>'.$branch['address'].'</option>';
								}
								else{
									echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
								}
							}
								echo'</select>';
							?>
					</div>
				</div>
			</div>
	
			<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<label for="s_phn">Contact Details:</label>
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
						<textarea placeholder="Address" name="s_address" class="s_address input form-control" id="s_address" rows="3" ><?php if (isset($address)) {echo $address;} ?></textarea>
					</div>
					<div class="col-md-6">
						<label for="s_totalSalary" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Total Salary</label><input type="text" class="s_totalSalary input form-control" id="s_totalSalary" name="s_totalSalary" value="<?php echo $totalSalary; ?>" style="margin-bottom: 4px;width: 200px;display: inline-block;text-align: right;"/>

						<label for="s_paidSalary" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Paid Salary</label><input type="text" class="s_paidSalary input form-control" id="s_paidSalary" name="s_paidSalary" value="<?php echo $paidSalary; ?>" style="margin-bottom: 4px;width: 200px;display: inline-block;text-align: right;"/>

						<label for="s_doj" class="input form-control" style="width: 150px;display: inline-block;border-right: 0px;border-radius: 3px 0px 0px 3px;">Date of Joining</label><input type="date" class="s_doj input form-control" id="s_doj" name="s_doj" value="<?php echo $doj; ?>" style="width: 200px;display: inline-block;"/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<select name="s_state" id="s_state" class="s_state input form-control" onchange="fetchCities(this.value,'s_city');">
							<option disabled selected value="0">State</option>
						<?php 
						foreach ($result as $r){
							if ($staff['state'] == $r['stateID']){
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
									echo'<option disabled selected>City</option>';
								}
							?>
						</select>
						<span class="text-danger" id="error-s_city"></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-md-12 text-center">
						<!-- <input type="hidden" name="id" value="<?php /*echo '$staffId'*/; ?>" /> -->
						
						<button type="submit" id="btn_save" class="btn btn-outline-success btn-lg" name="satff_save" value="satff_save">Save</button>
						
						<button type="button" id="btn_exit" class="btn btn-outline-danger btn-lg">Exit</button>
					</div>
				</div>
			</div>
		
		</form>
	</div>
</body>
</html>