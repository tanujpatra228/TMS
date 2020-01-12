<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');
# Fill branch_selector in dashboard.php -> PANE STUDENT
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo'<option value="0" disabled selected>Select Branch</option>';
		foreach ($result as $branch) {
			//echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch" value="'.$branch['branchId'].'"/> '.$branch['address'].'</label></span>';
			echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
		}
	}
#------------------------------------------------------

# FETCH STAFF OF SELECTED BRANCH
	function fillStaffSelector($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];

		$q = "SELECT * FROM tbl_staff
		WHERE tbl_staff.branchId LIKE '$branchId'
		AND tbl_staff.tutionId LIKE '$tutionId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo '<option disabled selected value="0">Select Staff</option>';
		foreach ($result as $row) {
			echo '<option value="'.$row['staffId'].'">'.$row['name'].'</option>';
		}
	}
#------------------------------------------------------

# SAVE SALARY
	function saveSalary($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];
		$staffId = $_POST['staffId'];
		$date = $_POST['salary_date'];
		$amt = $_POST['salary_amount'];

		$q = "INSERT INTO tbl_salary(tutionId,staffId,branchId,amt,`date`) VALUES('".$tutionId."','".$staffId."','".$branchId."','".$amt."','".$date."')";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));

		if ($result > 0) {
			$q = "UPDATE tbl_staff SET paidSalary = (SELECT SUM(amt) FROM tbl_salary WHERE staffId LIKE '$staffId')";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			
			$select = "SELECT * FROM tbl_staff WHERE staffId LIKE '$staffId'";
			$staff = mysqli_fetch_array(mysqli_query($conn, $select)) or die(mysqli_error($conn));
			$ToEmail = $staff['email'];
			$ToName = $staff['name'];
			$FromName = 'TMS';
			$bcc = 'tanujpatra228@gmail.com';
			$subject = 'Salary';
			$messageBody = 'Hello! '.$staff['name'].'<br/>&nbsp;&nbsp;&nbsp;&nbsp;You have been paid : <strong>"'.$amt.'"</strong> on <strong>"'.$date.'"</strong>';

			//echo sendMail($ToEmail, 'Tanuj Patra', 'STONE',$bcc,$subject,$messageBody) or die('cant send 1');
			//sleep(2000);
			echo sendMail($ToEmail,$ToName,$FromName,$bcc,$subject,$messageBody) or die('cant send 2');
			echo $result;
		}
		else{
			echo "Can't insert!";
		}
	}
#------------------------------------------------------

# FETCH TOTAL SALARY
	function fetchTotalSalary($conn){
		$staffId = $_POST['staffId'];
		//echo'alert("'.$staffId.'");';
		$q = "SELECT totalSalary FROM tbl_staff WHERE staffId LIKE '$staffId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($result);

		echo $row['totalSalary'];
	}
#------------------------------------------------------

# Fill "std_selector" in dashboard.php -> PANE STUDENT
	/*function fillStdSelector($conn){
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
				echo'<span class="options"><label><input type="checkbox" class="checkbox" name="course" value="'.$course['short_name'].'" onclick="filterStudData();"> '.$course['name'].'</label></span>';
			}
		}
		
		//echo'<script>console.log("'.$q.'");</script>';
	}*/
#------------------------------------------------------


# FETCH LAST 5 SALARY TRANSACTION
	function lastSalary($conn){
		$tutionId = $_POST['tutionId'];
		$q = "SELECT tbl_staff.*, tbl_salary.*, tbl_branch.address as baddress FROM tbl_staff, tbl_salary, tbl_branch
		WHERE tbl_salary.staffId = tbl_staff.staffId
		AND tbl_staff.branchId = tbl_branch.branchId
		AND tbl_salary.tutionId LIKE'".$tutionId."' ORDER BY Id DESC;";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$num = mysqli_num_rows($result);
		if ($num > 5 ) {
			for ($i=0; $i <= 5 ; $i++) { 
				$row = mysqli_fetch_array($result);
				echo '<tr>';
				echo'<th>'.$row['date'].'</th>';
				echo'<th>'.$row['name'].'</th>';
				echo'<th>'.$row['baddress'].'</th>';
				echo'<th>'.$row['amt'].'</th>';
				echo'<th>'.$row['totalSalary'].'</th>';	
				// echo'<th>'.$row['totpaid'].'</th>';	
				echo '</tr>';
			}
		}
		else{
			foreach ($result as $row) {
				echo '<tr>';
				echo'<th>'.$row['date'].'</th>';
				echo'<th>'.$row['name'].'</th>';
				echo'<th>'.$row['baddress'].'</th>';
				echo'<th>'.$row['amt'].'</th>';
				echo'<th>'.$row['totalSalary'].'</th>';	
				// echo'<th>'.$row['totpaid'].'</th>';	
				echo '</tr>';
			}
		}
	}
#------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);

?>