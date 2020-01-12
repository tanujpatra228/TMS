<?php
include'../includes/connect.inc.php';
$conn = connection('tms');

function fetchMarks($conn){

	/*$q = "SELECT tbl_student.* ,tbl_marks.* FROM tbl_marks , tbl_student
	WHERE tbl_student.studentId = tbl_marks.studentId
	AND tbl_student.tutionId LIKE '".$_POST['tutionId']."'
	AND tbl_marks.date LIKE '".$_POST['date']."'";
	$result = mysqli_query($conn, $q);
	$num = mysqli_num_rows($result);
	
	if ($num < 1) {
		$q = "INSERT INTO tbl_marks(`date`) VALUES('".$_POST['date']."');";
		mysqli_query($conn, $q);
		echo mysqli_error($conn);
	}*/

	$q = "SELECT tbl_student.* ,tbl_marks.* FROM tbl_marks , tbl_student
		WHERE tbl_student.studentId = tbl_marks.studentId
		AND tbl_student.tutionId LIKE '".$_POST['tutionId']."'";
	
	$result = mysqli_query($conn, $q);
	echo mysqli_error($conn);
	
	$i = 1;
	foreach ($result as $row) {
		echo'<tr>';
		echo'<td>'.$i.'<input type="hidden" value="'.$row['studentId'].'" name="studentId[]" /></td>';
		echo'<td>'.$row['name'].'</td>';
		echo'<td><input class="input"type="text" value="'.$row['eng1'].'" name="eng[]"/></td>';
		echo'<td><input class="input"type="text" value="'.$row['gramer'].'" name="gramer[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['maths'].'" name="maths[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['sci'].'" name="sci[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['ss'].'" name="ss[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['env'].'" name="env[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['gk'].'" name="gk[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['hindi'].'" name="hindi[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['computer'].'" name="computer[]" /></td>';
		// echo'<td><input class="input"type="text" value="'.$row['eco'].'" name="eco[]" /></td>';
		// echo'<td><input class="input"type="text" value="'.$row['oc'].'" name="oc[]" /></td>';
		// echo'<td><input class="input"type="text" value="'.$row['ac'].'" name="ac[]" /></td>';
		echo'<td><input class="input"type="text" value="'.$row['guj'].'" name="guj[]" /></td>';
		echo'</tr>';
		$i += 1;
	}
}

function updateMarks($conn){
	$q = "UPDATE tbl_marks SET `date` = '".$_POST['date']."'";
}

$func = $_REQUEST['func'];
$func($conn);
mysqli_close($conn);

?>