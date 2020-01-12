<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');

# Fill "branch_selector" in dashboard.php -> PANE STAFF
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q);
		foreach ($result as $branch) {
			echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch[]" value="'.$branch['branchId'].'" onclick="filterStaffData();"/> '.$branch['address'].'</label></span>';
		}
	}
#------------------------------------------------------

# Fill "std_selector" in dashboard.php -> PANE STAFF
	function fillStdSelector($conn){
		$q = "SELECT course FROM tbl_tution WHERE tutionId LIKE '".$_POST['tutionId']."'";
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
		$result = mysqli_query($conn, $q);

		/*if (isset($_REQUEST['calling_func'])){
			foreach ($result as $course) {
				echo '<option value="'.$course['short_name'].'" style="color:#111;">'.$course['name'].'</option>';
			}
		}*/
		foreach ($result as $course) {
			echo'<span class="options"><label><input type="checkbox" class="checkbox" name="course[]" value="'.$course['short_name'].'" onclick="filterStaffData();"> '.$course['name'].'</label></span>';
		}
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# Fill "staff_data", Display Staff in dashboard.php -> PANE STAFF
	function displayStaff($conn){
		$branchId = '';
		$courseId = '';

		if (isset($_POST['branch']) ) {
			$n = 1;
			$branchId = 'IN (';
			foreach ($_POST['branch'] as $branch){
				if ($n) {
					$branchId .= "'".$branch."'";
				}else{
					$branchId .= ",'".$branch."'";
				}
				$n = 0;
			}
			$branchId .= ')';
		}
		else{
			$branchId = "LIKE '%'";
		}
			// Course selector 
		if (isset($_POST['course'])) {
			$n = 1;
			$courseId = 'IN (';
			foreach ($_POST['course'] as $course) {
				if ($n) {
					$courseId .= "'".$course."'";
				}else{
					$courseId .= ",'".$course."'";
				}
				$n = 0;
			}
			$courseId .= ')';
		}
		else{
			$courseId = "LIKE '%'";
		}
			// Search filter textbox
		if ($_POST['search_filter'] != '') {
			$search_filter = '%'.$_POST['search_filter'].'%';
		}
		else{
			$search_filter = '%';
		}

		$OR = " tbl_staff.staffId IN (SELECT tbl_staff.staffId FROM tbl_staff WHERE tbl_staff.name LIKE '".$search_filter."' OR tbl_staff.sex LIKE '".$search_filter."' OR tbl_staff.phone LIKE '".$search_filter."' OR tbl_staff.email LIKE '".$search_filter."' OR tbl_staff.qualification LIKE '".$search_filter."' OR tbl_staff.totalSalary LIKE '".$search_filter."' OR tbl_staff.paidSalary LIKE '".$search_filter."' OR tbl_staff.type LIKE '".$search_filter."')";

		if ($search_filter != '%') {
			$q = "SELECT tbl_branch.address as branchAddress, tbl_staff.* FROM tbl_staff, tbl_branch, tbl_tution WHERE tbl_staff.branchId = tbl_branch.branchId AND tbl_staff.branchId ".$branchId." AND".$OR." GROUP BY tbl_staff.staffId";
		}
		else{
			$q = "SELECT tbl_branch.address as branchAddress, tbl_staff.* FROM tbl_staff, tbl_branch, tbl_tution WHERE tbl_staff.branchId = tbl_branch.branchId AND tbl_staff.tutionId LIKE '".$_POST['tutionId']."' AND tbl_staff.branchId ".$branchId." GROUP BY tbl_staff.staffId";
		}
		//echo'<script>console.log("'.$q.'");</script>';
		
		$result = mysqli_query($conn, $q);
		$i = 1;
		foreach ($result as $staff) {
			echo'<tr id="'.$staff['staffId'].'" class="tr_'.$_POST['tutionId'].'">';
			echo'<td>'.$i.'</td>';
			echo'<td><input type="text" class="input" value="'.$staff['name'].'" title="'.$staff['name'].'" disabled="disabled" onclick="makeEditable(\'newstaff'.$i.'\')"></td>';
			echo'<td><input type="text" class="input text-center" value="'.$staff['doj'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-center" value="'.$staff['branchAddress'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-center" value="'.$staff['phone'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-right" value="'.$staff['totalSalary'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-right" value="'.$staff['paidSalary'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-center" value="'.$staff['type'].'" disabled="disabled"></td>';
			echo'<td colspan="3"><button type="button" class="btn btn-outline-info" title="Edit" onclick="editWindow(\''.$staff['staffId'].'\',\'staff\');"><span class="glyphicon glyphicon-edit"></span></button><button title="Delete" type="button" class="btn btn-outline-danger" onclick="deleteStaff(\''.$staff['staffId'].'\');"><span class="glyphicon glyphicon-trash"></span></button></td>';
			echo'</tr>';
			$i += 1;
		}
		if (mysqli_num_rows($result) < 1) {
			echo'<tr>';
			echo'<td>No result found!</td>';
			echo'</tr>';
		}
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# INSERT "Staff data" from dashboard.php -> PANE STAFF
	function insert_staff($conn){
		$staff_branch = $_POST['staff_branch'];
		$staff_name = $_POST['staff_name'];
		$staff_middle_name = $_POST['staff_middle_name'];
		$staff_sex = $_POST['staff_sex'];
		$staff_phn = $_POST['staff_phn'];
		$staff_email = $_POST['staff_email'];

		$staff_qualification = $_POST['staff_qualification'];

		$staff_total_salary = $_POST['staff_total_salary'];
		$staff_salary_paid = $_POST['staff_salary_paid'];
		//$staff_exp = $_POST['staff_exp']; not in insert form through "dashboard.php"
		$tutionId = $_POST['tutionId'];

		$staff_doj = $_POST['staff_doj'];
		$staff_type = $_POST['staff_type'];
		$staff_pwd = '123456789';
		$staff_pwd = password_hash($staff_pwd,PASSWORD_DEFAULT);
		
		$i = 0;	// Array index
		$result = 0;

		foreach ($staff_branch as $branch) {
			// Query to fetch higest "staffId" from student table associated with different Branch
			$q = "SELECT MAX(staffId) as staffId FROM `tbl_staff` WHERE branchId LIKE '".$branch."';";
			$last_staff = mysqli_fetch_array(mysqli_query($conn, $q));
			
			if (!isset($last_staff['staffId'])) {
				// Generating New studentId
				$staffId_value = $branch.'#S:1';
			}
			else{
				// Generating next studentId
				$last_staff_num = preg_split("/:/",$last_staff['staffId']);
				$new_staff_Id = $last_staff_num[1] + 1;
				$staffId_value = $branch.'#S:'.$new_staff_Id;  // Next studentId
			}

			$ins_q = "INSERT INTO `tbl_staff` (`tutionId`, `branchId`, `staffId`, `name`, `middleName`, `sex`, `phone`, `email`, `password`, `qualification`, `totalSalary`, `paidSalary`, `doj`, `type`) VALUES('".$tutionId."', '".mysqli_real_escape_string($conn, $branch)."', '".$staffId_value."', '".mysqli_real_escape_string($conn, $staff_name[$i])."', '".mysqli_real_escape_string($conn, $staff_middle_name[$i])."', '".mysqli_real_escape_string($conn, $staff_sex[$i])."', '".mysqli_real_escape_string($conn, $staff_phn[$i])."', '".mysqli_real_escape_string($conn, $staff_email[$i])."', '".mysqli_real_escape_string($conn, $staff_pwd)."', '".mysqli_real_escape_string($conn, $staff_qualification[$i])."', '".mysqli_real_escape_string($conn, $staff_total_salary[$i])."', '".mysqli_real_escape_string($conn, $staff_salary_paid[$i])."', '".$staff_doj."', '".mysqli_real_escape_string($conn, $staff_type[$i])."')";
			

			$insert = mysqli_query($conn, $ins_q) or die(mysqli_error($conn));//die('Can\'t insert Staff on Branch '.$branch);
			$result = $result + $insert;
			
			//$urlId = str_replace("#", "-", $studentId_value);
			$messageBody = "<p style='padding:10px;border-radius:8px;background-color:#fff;'>Hello! $staff_name[$i],<br/>&nbsp;&nbsp;&nbsp;You have hired in Star Track,<br/>Salary Details:<br/>Total : $staff_total_salary[$i]<br/>Paid : $staff_salary_paid[$i]<br/><br/> Now you can manage data in your Dashboard. Visit www.tutionmanagementsystem.com<br/><br/>Login Details:<br/><strong>Email = $staff_email[$i]<br/>Password = 123456789</strong><br/>Or<br/> <a href='http://192.168.43.59/TYproject/login_teacher.php?staffId=$staff_email[$i]'>Click Here!</a><br/><br/><br/><br/><div style='text-align: center;'><small>&copy;TMS 2019</small></div></p>";
			sendMail($staff_email[$i], $staff_name[$i], 'TMS', 'startracks22@gmail.com', 'Login Details',$messageBody);

			$i = $i + 1;
		}
		$ins_q .= ";";
		//echo $ins_q;

		if ($result >= 1) {
				echo ' rescords inserted.';
			}
			else{
				echo 'failed to insert records!';
			}
			$i += 1;
	}
#------------------------------------------------------

# DELETE "Staff data" from dashboard.php -> PANE STAFF
	function delete_staff($conn){
		$q = "DELETE FROM tbl_staff WHERE staffId LIKE '".$_POST['staffId']."';";
		 /*delete student data from all reports also*/ // <-- Work not done
		 /*$q = "DELETE FROM tbl_student WHERE staffId LIKE '".$_POST['staffId']."'; DELETE FROM tbl_reports WHERE staffId LIKE '".$_POST['staffId']."';"; */
		$result = mysqli_query($conn, $q);
		echo $_POST['staffId'].' Deleted.';
	}
#------------------------------------------------------

# UPDATE "Staff data" from dashboard.php -> PANE STAFF
	if (isset($_POST['satff_save']) || isset($_POST['staff_save_exit'])) {
		$fname = mysqli_real_escape_string($conn, $_POST['f_name']);
		$mname = mysqli_real_escape_string($conn, $_POST['m_name']);
		$lname = mysqli_real_escape_string($conn, $_POST['l_name']);
		$sex = mysqli_real_escape_string($conn, $_POST['s_sex']);
		$qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
		$branch = mysqli_real_escape_string($conn, $_POST['s_branch']);
		$phn = mysqli_real_escape_string($conn, $_POST['s_phn']);
		$email = mysqli_real_escape_string($conn, $_POST['s_email']);
		$totalSalary = mysqli_real_escape_string($conn, $_POST['s_totalSalary']);;
		$doj = mysqli_real_escape_string($conn, $_POST['s_doj']);;
		$address = mysqli_real_escape_string($conn, $_POST['s_address']);
		$state = mysqli_real_escape_string($conn, $_POST['s_state']);
		$city = mysqli_real_escape_string($conn, $_POST['s_city']);

		$id = mysqli_real_escape_string($conn, $_POST['id']);
		$q = "UPDATE `tbl_staff` SET `name` = '".$fname.' '.$lname."', `middleName` = '".$mname."', `sex` = '".$sex."', `branchId` = '".$branch."', `phone` = '".$phn."', `email` = '".$email."', `qualification` = '".$qualification."', `totalSalary` = '".$totalSalary."', `doj` = '".$doj."', `address` = '".$address."', `state` = '".$state."', `city` = '".$city."' WHERE `tbl_staff`.`staffId` = '".$staffId."';";
		$result = mysqli_query($conn ,$q);
		
		if ($result > 0) {
			
			if (isset($_POST['staff_save_exit'])) {
				echo '<script>self.close();</script>';
			}
		}
	}else{
#------------------------------------------------------
$func = $_REQUEST['func'];
$func($conn);
}
mysqli_close($conn);
?>