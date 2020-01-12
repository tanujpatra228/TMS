<?php
include'../includes/connect.inc.php';

$conn = connection('tms');

# Fill branch_selector in dashboard.php -> PANE ATTENDENCE
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q);
		foreach ($result as $branch) {
			echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch[]" value="'.$branch['branchId'].'" onclick="filterData();"/> '.$branch['address'].'</label></span>';
		}
	}
#------------------------------------------------------

# Fill branch_selector in dashboard.php -> PANE ATTENDENCE
	function fillBranchSelector_staff($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q);
		foreach ($result as $branch) {
			echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch[]" value="'.$branch['branchId'].'" onclick="filterData_staff();"/> '.$branch['address'].'</label></span>';
		}
	}
#------------------------------------------------------


# Fill "std_selector" in dashboard.php -> PANE ATTENDENCE
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
				echo'<span class="options"><label><input type="checkbox" class="checkbox" name="course[]" value="'.$course['short_name'].'" onclick="filterData();"> '.$course['name'].'</label></span>';
			}
		}
		
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# Fill "student_data", Display Students in dashboard.php -> PANE ATTENDENCE
	function displayStudents($conn){
		$branchId = '';
		$courseId = '';
		$date = date('Y-m-d');	// Server date
		$date2 = '2019-03-31';

		if ($date == $date2) {
		    echo "same";
		}
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
		
		$q = "";
		if ($_POST['period'] == 'today') {

			$q = "SELECT * FROM tbl_student WHERE tbl_student.tutionId LIKE '".$_POST['tutionId']."'
				AND tbl_student.std ".$courseId." AND tbl_student.branchId ".$branchId." ORDER BY tbl_student.branchId";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			$i = 1;
			foreach ($result as $student) {
				echo'<tr id="'.$student['studentId'].'" class="tr_'.$_POST['tutionId'].'">';
				echo'<td>'.$i.'</td>';
				echo'<td><label for="'.$student['studentId'].'">'.$student['name'].'</label></td>';
				echo'<td><input type="checkbox" class="input" name="studentId[]" value="'.$student['studentId'].'" checked/></td>';
				echo'</tr>';
				$i += 1;
			}
			if (mysqli_num_rows($result) < 1) {
				echo'<tr>';
				echo'<td>No result found!</td>';
				echo'</tr>';
			}

		}
		else{
			$q = "SELECT * FROM tbl_student WHERE tbl_student.studentId IN (SELECT Id FROM tbl_attendence WHERE `date` LIKE '".$_POST['date']."') AND tbl_student.tutionId LIKE '".$_POST['tutionId']."'AND tbl_student.std ".$courseId."AND tbl_student.branchId ".$branchId." GROUP BY tbl_student.studentId";
		
			$result = mysqli_query($conn, $q);
			$i = 1;
			foreach ($result as $student) {
				echo'<tr id="'.$student['studentId'].'" class="tr_'.$_POST['tutionId'].'">';
				echo'<td>'.$i.'</td>';
				echo'<td><label for="'.$student['studentId'].'">'.$student['name'].'</label></td>';
				echo'<td><input type="checkbox" class="input" name="studentId[]" value="'.$student['studentId'].'" checked/></td>';
				echo'</tr>';
				$i += 1;
			}

			if (mysqli_num_rows($result) < 1) {
				echo'<tr>';
				echo'<td>No result found!</td>';
				echo'</tr>';
			}
		}
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# Insert into Attendence from dashboard.php -> PANE ATTENDENCE
	function takeAttendence($conn){
		$tutionId = $_POST['tutionId'];
		$date = $_POST['date'];

		foreach ($_POST['studentId'] as $studentId) {
			$q = "INSERT INTO tbl_attendence(tutionId,`date`, Id,type) VALUES('".$tutionId."','".$date."','".$studentId."','student');";
			$result = mysqli_query($conn, $q);
			echo $result;
		}
	}
#------------------------------------------------------

# FETCH Attendence data from "student Index.php"
	function fetchAttendence($conn){
		$prevDate = $_POST['prev_date'];
		$endDate = $_POST['end_date'];
		$studentId = $_POST['studentId'];

		$q = "SELECT COUNT(*) AS present FROM tbl_attendence WHERE Id LIKE '$studentId'";
		$result = mysqli_fetch_array(mysqli_query($conn, $q));
		echo $result['present'];
	}
#------------------------------------------------------

# Fill "staff_data", Display Students in dashboard.php -> PANE ATTENDENCE
	function displayStaff($conn){
		$branchId = '';
		$courseId = '';
		$date = date('Y-m-d');	// Server date
		$date2 = '2019-03-31';

		if ($date == $date2) {
		    echo "same";
		}
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
		
		$q = "";
		if ($_POST['period'] == 'today') {

			$q = "SELECT * FROM tbl_staff WHERE tbl_staff.tutionId LIKE '".$_POST['tutionId']."'
			AND tbl_staff.branchId ".$branchId." ORDER BY tbl_staff.branchId";
			$result = mysqli_query($conn, $q);
			$i = 1;
			foreach ($result as $staff) {
				echo'<tr id="'.$staff['staffId'].'" class="tr_'.$_POST['tutionId'].'">';
				echo'<td>'.$i.'</td>';
				echo'<td><label for="'.$staff['staffId'].'">'.$staff['name'].'</label></td>';
				echo'<td><input type="checkbox" class="input" name="staffId[]" value="'.$staff['staffId'].'" checked/></td>';
				echo'</tr>';
				$i += 1;
			}
			if (mysqli_num_rows($result) < 1) {
				echo mysqli_error($conn);
				echo'<tr>';
				echo"<td>No result found! ".$_POST['date']."</td>";
				echo'</tr>';
			}

		}
		else{
			$q = "SELECT * FROM tbl_staff WHERE tbl_staff.staffId IN (SELECT Id FROM tbl_attendence WHERE `date` LIKE '".$_POST['date']."') AND tbl_staff.tutionId LIKE '".$_POST['tutionId']."' AND tbl_staff.branchId ".$branchId." GROUP BY tbl_staff.staffId";
		
			$result = mysqli_query($conn, $q);
			$i = 1;
			foreach ($result as $staff) {
				echo'<tr id="'.$staff['staffId'].'" class="tr_'.$_POST['tutionId'].'">';
				echo'<td>'.$i.'</td>';
				echo'<td><label for="'.$staff['staffId'].'">'.$staff['name'].'</label></td>';
				echo'<td><input type="checkbox" class="input" name="staffId[]" value="'.$staff['studentId'].'" checked/></td>';
				echo'</tr>';
				$i += 1;
			}

			if (mysqli_num_rows($result) < 1) {
				echo'<tr>';
				echo"<td>No result found! ".$_POST['date']."</td>";
				echo'</tr>';
			}
		}
		//echo'<script>console.log("'.$q.'");</script>';
	}
#------------------------------------------------------

# takeAttendenceStaff
	function takeAttendenceStaff($conn){
		$tutionId = $_POST['tutionId'];
		$date = $_POST['date'];

		foreach ($_POST['staffId'] as $staffId) {
			$q = "INSERT INTO tbl_attendence(tutionId,`date`, Id,type) VALUES('".$tutionId."','".$date."','".$staffId."','staff');";
			$result = mysqli_query($conn, $q);
			echo $result;
			echo mysqli_error($conn);
		}
	}
#------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
echo mysqli_error($conn);
mysqli_close($conn);
?>