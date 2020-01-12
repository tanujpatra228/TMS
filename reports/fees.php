<?php

include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');


# Fill branch_selector in fees.report.php
	function fillBranchSelector($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo'<option disabled value="0" selected>Select Branch</option>';
		foreach ($result as $branch) {
			//echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch" value="'.$branch['branchId'].'"/> '.$branch['address'].'</label></span>';
			echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
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
			echo '<option disabled selected value="0" style="color:#111;">Select STD</option>';
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

# Fill Student Selector
	function fillStudentSelector($conn){
		$tutionId = $_POST['tutionId'];

		if (($_POST['branchId']) != null) {
			$branchId = $_POST['branchId'];
		}
		else{
			$branchId = '%';
		}

		if (($_POST['std']) != null) {
			$std = $_POST['std'];
		}
		else{
			$std = '%';
		}
		$q = "SELECT studentId,name FROM tbl_student 
			WHERE tbl_student.tutionId LIKE '$tutionId'
			AND tbl_student.std LIKE '$std'
			AND tbl_student.branchId LIKE '$branchId'";

		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo'<option value="0">Select Student</option>';
		foreach ($result as $row) {
			echo'<option value="'.$row['studentId'].'">'.$row['name'].'</option>';
		}
	}
#-------------------------------------------------------

# Fill Search Student Fees
	function searchStudent($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = '';
		$std = '';
		$studentId = $_POST['studentId'];
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];

		/*if ($_POST['studentId'] != null) {
			$studentId = $_POST['studentId'];
		}
		else{
			$studentId = '%';
		}*/

		if (isset($_POST['branchId'])) {
			$branchId = $_POST['branchId'];
		}
		else{
			$branchId = '%';
		}

		if (isset($_POST['std'])) {
			$std = $_POST['std'];
		}
		else{
			$std = '%';
		}

		$q = "SELECT tbl_fees.date,tbl_branch.address,tbl_student.name,tbl_fees.amt AS lastPaid,tbl_student.totalFees,(totalFees-SUM(amt)) AS remaining FROM `tbl_fees`, tbl_student, tbl_branch
			WHERE tbl_student.studentId = tbl_fees.studentId
			AND tbl_student.branchId = tbl_branch.branchId
			AND tbl_student.studentId LIKE '$studentId'
			AND tbl_fees.tutionId LIKE '$tutionId'
			AND tbl_fees.branchId LIKE '$branchId'
			AND tbl_student.std LIKE '$std'
			GROUP by tbl_fees.studentId";

		$q_last_paid = "SELECT tbl_student.name, tbl_fees.date, tbl_fees.amt AS Amount_paid 
			FROM tbl_student, tbl_fees 
			WHERE tbl_student.studentId = tbl_fees.studentId 
			AND tbl_fees.tutionId LIKE '$tutionId' 
			AND tbl_fees.studentId LIKE '$studentId' 
			AND tbl_student.std LIKE '$std' 
			AND tbl_fees.date BETWEEN '$from_date' AND '$to_date' 
			ORDER BY date DESC";

		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		$all_transaction = mysqli_query($conn, $q_last_paid) or die(mysqli_error($conn));

		
		$student = mysqli_fetch_array($result);
		echo'<div class="col-md-12">';
		echo '<p class="display-4" style="font-size: 3rem;">Last Paid</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Name</label>: '.$student['name'].'</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Date</label>: '.$student['date'].'</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Branch</label>: '.$student['address'].'</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Last Paid</label>: '.$student['lastPaid'].'</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Total Fees</label>: '.$student['totalFees'].'</p>';
		echo '<p style="margin-bottom:0px;"><label style="width:120px;">Remaining Fees</label>: '.$student['remaining'].'</p>';
		echo'</div>';

		echo'<div class="row">';
		echo'<div class="col-md-12">';
		echo'<p class="display-4" style="font-size: 3rem;">All Transaction</p>';
		echo'</div>';
		echo'<div class="col-md-12">';
		echo'<table id="table" class="table table-bordered table-hover table-striped">
				<thead>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Name</th>
						<th>Paid</th>
					</tr>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Name</th>
						<th>Paid</th>
					</tr>
				</thead>
				<tbody>';
				$i = 1;
				foreach ($all_transaction as $row) {
					echo'<tr>';
					echo'<td>'.$i.'</td>';
					echo'<td>'.$row['name'].'</td>';
					echo'<td>'.$row['date'].'</td>';
					echo'<td>'.$row['Amount_paid'].'</td>';
					echo'</tr>';
					$i++;
				}
				echo'</tbody>
			</table>';
			echo'<div>';
			echo'<div>';
			echo"<script>
					$('#table').DataTable({
						initComplete: function(){
							this.api().columns().every(function(){
								var column = this;
								var select = $('<select><option value=\"\"></option></select>')
									.appendTo($(column.header()).empty())
									.on('change', function(){
										var val = $.fn.dataTable.util.escapeRegex(
											$(this).val()
										);

										column
											.search(val ? '^'+val+'$' : '', true, false).draw();
									});
								column.data().unique().sort().each(function(d, j){
									select.append('<option value=\"'+d+'\">'+d+'</option>')
								});
							});
						}
					});
				</script>";
	}
#-------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);

?>
<!-- 
<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Name</th>
			<th>Paid</th>
		</tr>
		<tr>
			<th>#</th>
			<th>Date</th>
			<th>Name</th>
			<th>Paid</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
</table> -->