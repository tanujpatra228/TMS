<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');

# Fill branch_selector in dashboard.php -> PANE STUDENT
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q);
		foreach ($result as $branch) {
			echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch[]" value="'.$branch['branchId'].'" onclick="filterStudData();"/> '.$branch['address'].'</label></span>';
		}
	}
#------------------------------------------------------

# Fill "std_selector" in dashboard.php -> PANE STUDENT
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

		if (isset($_REQUEST['calling_func'])){
			foreach ($result as $course) {
				echo '<option value="'.$course['short_name'].'" style="color:#111;">'.$course['name'].'</option>';
			}
		}else{
			foreach ($result as $course) {
				echo'<span class="options"><label><input type="checkbox" class="checkbox" name="course[]" value="'.$course['short_name'].'" onclick="filterStudData();"> '.$course['name'].'</label></span>';
			}
		}
		
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# Fill "student_data", Display Students in dashboard.php -> PANE STUDENT
	function displayStudents($conn){
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

		if ($_POST['search_filter'] != '') {
			$search_filter = $_POST['search_filter'].'%';
		}
		else{
			$search_filter = '%';
		}

		$OR = " tbl_student.studentId IN (SELECT tbl_student.studentId FROM tbl_student WHERE tbl_student.name LIKE '".$search_filter."' OR tbl_student.studentId LIKE '".$search_filter."' OR tbl_student.sex LIKE '".$search_filter."' OR tbl_student.phone LIKE '".$search_filter."' OR tbl_student.email LIKE '".$search_filter."' OR tbl_student.totalFees LIKE '".$search_filter."' OR tbl_student.paidFees LIKE '".$search_filter."')";

		if ($search_filter != '%') {

			$q = "SELECT tbl_branch.address as branchAddress, tbl_student.* FROM tbl_student, tbl_branch, tbl_tution WHERE tbl_student.branchId = tbl_branch.branchId AND tbl_student.tutionId LIKE '".$_POST['tutionId']."' AND tbl_student.branchId ".$branchId." AND tbl_student.std ".$courseId." AND".$OR." GROUP BY tbl_student.studentId";
		}else{
			$q = "SELECT tbl_branch.address as branchAddress, tbl_student.* FROM tbl_student, tbl_branch, tbl_tution WHERE tbl_student.branchId = tbl_branch.branchId AND tbl_student.tutionId LIKE '".$_POST['tutionId']."' AND tbl_student.branchId ".$branchId." AND tbl_student.std ".$courseId." GROUP BY tbl_student.studentId";
		}
		//echo'<script>console.log("'.$q.'");</script>';
		
		$result = mysqli_query($conn, $q);
		$i = 1;
		foreach ($result as $student) {
			echo'<tr id="'.$student['studentId'].'" class="tr_'.$_POST['tutionId'].'">';
			echo'<td>'.$i.'</td>';
			echo'<td><input type="text" class="input" title="'.$student['studentId'].'" value="'.$student['name'].'" disabled="disabled" onclick="makeEditable(\'newstudent'.$i.'\')"></td>';
			echo'<td><input type="text" class="input" value="'.$student['std'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input" value="'.$student['branchAddress'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input" value="'.$student['phone'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-right" value="'.$student['totalFees'].'" disabled="disabled"></td>';
			echo'<td><input type="text" class="input text-right" value="'.$student['paidFees'].'" disabled="disabled"></td>';
			echo'<td colspan="3"><button type="button" class="btn btn-outline-info" title="Edit" onclick="editWindow(\''.$student['studentId'].'\',\'student\');"><span class="glyphicon glyphicon-edit"></span></button><button title="Delete" type="button" class="btn btn-outline-danger" onclick="deleteStudent(\''.$student['studentId'].'\');"><span class="glyphicon glyphicon-trash"></span></button></td>';
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

# INSERT Student data from dashboard.php -> PANE STUDENT
	function insert_student($conn){
		$s_std = $_POST['s_std'];
		$s_branch = $_POST['s_branch'];
		$s_name = $_POST['s_name'];
		$s_fatherName = $_POST['s_father_name'];
		$s_sex = $_POST['s_sex'];
		$s_phn = $_POST['s_phn'];
		$s_email = $_POST['s_email'];
		$s_total_fees = $_POST['s_total_fees'];
		$s_fees_paid = $_POST['s_fees_paid'];
		$tutionId = $_POST['tutionId'];
		$s_pwd = '123456789';
		$s_pwd = password_hash($s_pwd,PASSWORD_DEFAULT);
		$i = 0;	// Array index
		$result = 0;
		foreach ($s_branch as $branch) {
			// Query to fetch higest "studentId" from student table associated with different Branch
			$q = "SELECT MAX(studentId) as studentId FROM `tbl_student` WHERE branchId LIKE '".$branch."';";
			$last_student = mysqli_fetch_array(mysqli_query($conn, $q));
			
			if (!isset($last_student['studentId'])) {
				// Generating New studentId
				$studentId_value = $branch.'#1';
			}
			else{
				// Generating next studentId
				$last_student_num = preg_split("/#/",$last_student['studentId']);
				$new_student_Id = $last_student_num[2] + 1;
				$studentId_value = $branch.'#'.$new_student_Id;  // Next studentId
			}

			$q = "INSERT INTO tbl_student(tutionId,branchId,studentId,name,fatherName,sex,phone,email,password,std,totalFees,paidFees) VALUES('".$tutionId."','".$branch."','".$studentId_value."','".$s_name[$i]."','".$s_fatherName[$i]."','".$s_sex[$i]."','".$s_phn[$i]."','".$s_email[$i]."','".$s_pwd."','".$s_std[$i]."','".$s_total_fees[$i]."','".$s_fees_paid[$i]."');";
			
			$insert = mysqli_query($conn, $q) or die('Can\'t insert Student on Branch '.$s_name[$i].' '.mysqli_error($conn));
			$result = $result + $insert;
			
			$urlId = str_replace("#", "-", $studentId_value);
			$messageBody = "<p style='padding:10px;border-radius:8px;background-color:#fff;'>Hello! $s_name[$i],<br/>&nbsp;&nbsp;&nbsp;Your admission process is completed in Star Track,<br/>Fees Details:<br/>Total : $s_total_fees[$i]<br/>Paid : $s_fees_paid[$i]<br/><br/> You can track your activities with our Student Panel after Login. Visit www.tutionmanagementsystem.com<br/><br/>Login Details:<br/><strong>StudentId = $studentId_value<br/>Password = 123456789</strong><br/>Or<br/> <a href='http://192.168.43.59/TYproject/login_stud.php?studentId=$urlId'>Click Here!</a><br/><br/><br/><br/><div style='text-align: center;'><small>&copy;TMS 2019</small></div></p>";
			sendMail($s_email[$i], $s_name[$i], 'TMS', 'startracks22@gmail.com', 'Login Details',$messageBody);
			//sleep(500);
			$i += 1;
		}

		if ($result >= 1) {
			echo 'rescords inserted.';
		}
		else{
			echo 'failed to insert records!';
		}
	}
#------------------------------------------------------

# DELETE Student data from dashboard.php -> PANE STUDENT
	function delete_student($conn){
		$q = "DELETE FROM tbl_student WHERE studentId LIKE '".$_POST['studentId']."';";
		 /*delete student data from all reports also*/ // <-- Work not done
		 /*$q = "DELETE FROM tbl_student WHERE studentId LIKE '".$_POST['studentId']."'; DELETE FROM tbl_reports WHERE studentId LIKE '".$_POST['studentId']."';"; */
		$result = mysqli_query($conn, $q);
		echo $_POST['studentId'].' Deleted.';
	}
#------------------------------------------------------

# FEES RECEIPT data from Student (index.php) 
	/*function feeReceipt(){
		$studentId = $_POST['studentId'];

		$q = "SELECT  FROM ";
	}*/
#------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);

?>