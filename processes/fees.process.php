<?php
include'../includes/connect.inc.php';
include'../fsins.php';

$conn =connection('tms');
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

# FETCH STUDENT OF SELECTED BRANCH
	function fillStudentSelector($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];

		$q = "SELECT * FROM tbl_student
		WHERE tbl_student.branchId LIKE '$branchId'
		AND tbl_student.tutionId LIKE '$tutionId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo '<option disabled selected value="0">Select Student</option>';
		foreach ($result as $row) {
			echo '<option value="'.$row['studentId'].'">'.$row['name'].'</option>';
		}
	}
#------------------------------------------------------

# SAVE FEES
	function saveFees($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];
		$studentId = $_POST['studentId'];
		$date = $_POST['fees_date'];
		$amt = $_POST['fees_amount'];

		$q = "INSERT INTO tbl_fees(tutionId,studentId,branchId,amt,`date`) VALUES('".$tutionId."','".$studentId."','".$branchId."','".$amt."','".$date."')";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));

		if ($result > 0) {
			$q = "UPDATE tbl_student SET paidFees = (SELECT SUM(amt) FROM tbl_fees WHERE studentId LIKE '$studentId')";
			echo $result;

			$select = "SELECT * FROM tbl_student WHERE studentId LIKE '$studentId'";
			$student = mysqli_fetch_array(mysqli_query($conn, $select)) or die(mysqli_error($conn));
			$ToEmail = $student['email'];
			$ToName = $student['name'];
			$FromName = 'TMS';
			$bcc = 'tanujpatra228@gmail.com';
			$subject = 'Fees';
			$messageBody = 'Hello! '.$student['name'].'<br/>&nbsp;&nbsp;&nbsp;&nbsp;You have been paid : <strong>"'.$amt.'"</strong> on <strong>"'.$date.'"</strong>';

			//echo sendMail($ToEmail, 'Tanuj Patra', 'STONE',$bcc,$subject,$messageBody) or die('cant send 1');
			//sleep(2000);
			echo sendMail($ToEmail,$ToName,$FromName,$bcc,$subject,$messageBody) or die('cant send 2');
		}
		else{
			echo "Can't insert!";
		}
	}
#------------------------------------------------------

# FETCH LAST 5 FEES TRANSACTION
	function lastFees($conn){
		$tutionId = $_POST['tutionId'];
		$q = "SELECT tbl_student.*, tbl_fees.*, tbl_branch.address as baddress FROM tbl_student, tbl_fees, tbl_branch
		WHERE tbl_fees.studentId =tbl_student.studentId
		AND tbl_student.branchId = tbl_branch.branchId
		AND tbl_fees.tutionId LIKE '".$tutionId."' ORDER BY Id DESC;";
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
				echo'<th>'.$row['totalFees'].'</th>';	
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
				echo'<th>'.$row['totalFees'].'</th>';	
				// echo'<th>'.$row['totpaid'].'</th>';	
				echo '</tr>';
			}
		}
	}
#------------------------------------------------------

# FETCH TOTAL FEES
	function fetchTotalFees($conn){
		$studentId = $_POST['studentId'];
		//echo'alert("'.$studentId.'");';
		$q = "SELECT totalFees FROM tbl_student WHERE studentId LIKE '$studentId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$totalFees = mysqli_fetch_array($result);

		$q = "SELECT *, SUM(amt) AS totalPaidFees FROM `tbl_fees` WHERE studentId LIKE '$studentId'";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$totalPaidFees = mysqli_fetch_array($result);

		echo $totalFees['totalFees'] - $totalPaidFees['totalPaidFees'];
	}
#------------------------------------------------------


$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);
?>