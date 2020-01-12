<?php

include'../includes/connect.inc.php';
include'../fsins.php';

$conn = connection('tms');


# Fill branch_selector in fees.report.php
	function fetchBranch($conn){
		$q = "SELECT branchId, address FROM tbl_branch WHERE tutionId LIKE '".$_POST['tutionId']."' ORDER BY branchId";
		$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
		echo'<option disabled value="0" selected>Select Branch</option>';
		foreach ($result as $branch) {
			//echo'<span class="options"><label class="label"><input type="checkbox" class="checkbox" name="branch" value="'.$branch['branchId'].'"/> '.$branch['address'].'</label></span>';
			echo'<option value="'.$branch['branchId'].'">'.$branch['address'].'</option>';
		}
	}
#------------------------------------------------------

# FETCH STAFF OF SELECTED BRANCH
	function fetchStaff($conn){
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

# FETCH STUDENT OF SELECTED BRANCH
	function fetchStudent($conn){
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


# FETCH STUDENT ATENDENCE DATA
	function searchData($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$cur_date = $_POST['date'];

		if (isset($_POST['studentId'])) {
			$studentId = $_POST['studentId'];
			$q = "SELECT MAX(tbl_attendence.date) AS Last_date,
					tbl_branch.address,
					SUM(tbl_attendence.attendence) AS present,
				    ($cur_date-SUM(tbl_attendence.attendence)) AS absent,
				    tbl_student.name,
				    tbl_student.std,
				    tbl_student.phone,
				    tbl_student.fatherName,
				    (SELECT COUNT(*) FROM tbl_attendence WHERE Id LIKE '$studentId' AND date LIKE '2019-04-$cur_date') AS today
				FROM `tbl_attendence`,tbl_student, tbl_branch
				WHERE tbl_student.studentId = tbl_attendence.Id
				AND tbl_student.branchId = tbl_branch.branchId
				AND tbl_attendence.tutionId LIKE '$tutionId'
				AND tbl_attendence.Id LIKE '$studentId'
				AND tbl_attendence.date BETWEEN '$from_date' AND '$to_date'
				GROUP BY tbl_attendence.Id";
			$student = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));
			if($student['today'] ==1){$today='Present';}else{$today = 'Absent';}
			echo '<div class="row">
					<div class="col-md-12">
						<table style="font-size:19px;">
							<tr><td>Last Present </td><td>:</td><td>'.$student['Last_date'].'</td></tr>
							<tr><td>Branch </td><td>:</td><td>'.$student['address'].'</td></tr>
							<tr><td>Name </td><td>:</td><td>'.$student['name'].'</td></tr>
							<tr><td>STD </td><td>:</td><td>'.$student['std'].'</td></tr>
							<tr><td>Today </td><td>:</td><td>'.$today.'</td></tr>
							<tr><td>Present </td><td>:</td><td>'.$student['present'].' days</td></tr>
							<tr><td>Absent </td><td>:</td><td>'.$student['absent'].' days</td></tr>
							<tr><td>Father Name </td><td>:</td><td>'.$student['fatherName'].'</td></tr>
							<tr><td>Phone no. </td><td>:</td><td>'.$student['phone'].'</td></tr>
						</table>
					</div>
				</div>';
				echo "<br/><br/>";

			$q = "SELECT date
				FROM tbl_attendence
				WHERE tbl_attendence.Id NOT IN('$studentId')
				AND tbl_attendence.date BETWEEN '2019-04-01' AND '2019-04-30'
				GROUP BY tbl_attendence.date";
			$dates = mysqli_query($conn, $q) or die(mysqli_error($conn));
			
			echo'<p style="font-size: 29px;text-align:center;"> Absent on </p>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>';
								$i = 1;
							foreach ($dates as $date) {
								echo'<tr>
										<td>'.$i.'</td>
										<td>'.$date['date'].'</td>
									</tr>';
								$i++;
							}
							echo'</tbody>
						</table>
					</div>
				</div>';
			echo"<script> $('table').DataTable(); </script>"; 
		}

		elseif (isset($_POST['staffId'])) {
			
			$staffId = $_POST['staffId'];
			$q = "SELECT MAX(tbl_attendence.date) AS Last_date,
				    tbl_branch.address,
				    SUM(tbl_attendence.attendence) AS present,
				    ($cur_date - SUM(tbl_attendence.attendence)) AS absent,
				    tbl_staff.name,
				    tbl_staff.phone,
				    tbl_staff.middleName,
				    (SELECT COUNT(*) FROM tbl_attendence WHERE Id LIKE '$staffId' AND `date` LIKE '2019-04-$cur_date') AS today
				FROM
				    tbl_attendence,
				    tbl_staff,
				    tbl_branch
				WHERE tbl_staff.staffId = tbl_attendence.Id 
				AND tbl_staff.branchId = tbl_branch.branchId 
				AND tbl_attendence.tutionId LIKE '$tutionId' 
				AND tbl_attendence.Id LIKE '$staffId' 
				AND tbl_attendence.date BETWEEN '$from_date' AND '$to_date'
				GROUP BY tbl_attendence.Id";
			$staff = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));
			if($staff['today'] ==1){$today='Present';}else{$today = 'Absent';}
			echo '<div class="row">
					<div class="col-md-12">
						<table style="font-size:19px;">
							<tr><td>Last Present </td><td>:</td><td>'.$staff['Last_date'].'</td></tr>
							<tr><td>Branch </td><td>:</td><td>'.$staff['address'].'</td></tr>
							<tr><td>Name </td><td>:</td><td>'.$staff['name'].'</td></tr>
							<tr><td>Today </td><td>:</td><td>'.$today.'</td></tr>
							<tr><td>Present </td><td>:</td><td>'.$staff['present'].' days</td></tr>
							<tr><td>Absent </td><td>:</td><td>'.$staff['absent'].' days</td></tr>
							<tr><td>Father Name </td><td>:</td><td>'.$staff['middleName'].'</td></tr>
							<tr><td>Phone no. </td><td>:</td><td>'.$staff['phone'].'</td></tr>
						</table>
					</div>
				</div>';
				echo "<br/><br/>";
			$q = "SELECT date
				FROM tbl_attendence
				WHERE tbl_attendence.Id NOT IN('$staffId')
				AND tbl_attendence.date BETWEEN '$from_date' AND '$to_date'
				GROUP BY tbl_attendence.date";
			$dates = mysqli_query($conn, $q) or die(mysqli_error($conn));
			
			echo'<p style="font-size: 29px;text-align:center;"> Absent on </p>
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>';
								$i = 1;
							foreach ($dates as $date) {
								echo'<tr>
										<td>'.$i.'</td>
										<td>'.$date['date'].'</td>
									</tr>';
								$i++;
							}
							echo'</tbody>
						</table>
					</div>
				</div>';
			echo"<script> $('table').DataTable(); </script>"; 
		}
	}
#------------------------------------------------------

$func = $_REQUEST['func'];
$func($conn);

mysqli_close($conn);
?>
<script type="text/javascript">
	$('table').DataTable();
</script>
<!-- <div class="row">
	<div class="col-md-12">
		<table>
			<tr><td>Last Present </td><td>:</td><td>'.$student['Last_date'].'</td></tr>
			<tr><td>Branch </td><td>:</td><td>'.$student['address'].'</td></tr>
			<tr><td>Name </td><td>:</td><td>'.$student['name'].'</td></tr>
			<tr><td>STD </td><td>:</td><td>'.$student['std'].'</td></tr>
			<tr><td>Today </td><td>:</td><td>'.$today.'</td></tr>
			<tr><td>Present </td><td>:</td><td>'.$student['present'].' days</td></tr>
			<tr><td>Absent </td><td>:</td><td>'.$student['absent'].' days</td></tr>
			<tr><td>Father Name </td><td>:</td><td>'.$student['fatherName'].'</td></tr>
			<tr><td>Phone no. </td><td>:</td><td>'.$student['phone'].'</td></tr>
		</table>
	</div>
</div>
<br/><br/>
<p style="font-size: 16px;"> Absent on </p>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>'.$i.'</td>
					<td>'.$data['date'].'</td>
				</tr>
			</tbody>
		</table>
	</div>
</div> -->