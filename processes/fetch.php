<?php
	include('../includes/connect.inc.php');
	$conn = connection('tms');	// CONNECT TO TMS

# fetch all branch and send data in table format to showBranch()-->fetch_tms.js
	function fetch_all_branch($conn){

		$q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '".mysqli_real_escape_string($conn,$_GET['tutionId'])."';";
		$result = mysqli_query($conn, $q) or die('can\'t execute query!');
		$i = 1;
		foreach($result as $r){
			echo '<tr id="branch'.$i.'" role="form">';
			echo '<td>'.$i.'<input type="hidden" name="branchId" value="'.$r['branchId'].'"></td>';
			echo '<td><input type="text" name="address" disabled="disabled" value="'.$r['address'].'"></td>';
			echo '<td><input type="text" name="state" disabled="disabled" value="'.$r['state'].'"></td>';
			echo '<td><input type="text" name="city" disabled="disabled" value="'.$r['city'].'"></td>';
			echo '<td><input type="text" name="phn" disabled="disabled" value="'.$r['phone'].'"></td>';
			echo '<td><button class="btn btn-info btn-sm edit_branch" onclick="makeEditable(\'#branch'.$i.'\');"><span class="glyphicon glyphicon-edit"></span></button>&nbsp;<button class="btn btn-danger btn-sm" onclick="deleteBranch(\''.$r['branchId'].'\',\''.$r['address'].'\',\''.$r['state'].'\',\''.$r['city'].'\',\''.$r['phone'].'\');"><span class="glyphicon glyphicon-trash"></span></button></td>';
			echo '</tr>';
			$i+=1;
		}
		if (mysqli_num_rows($result) < 1) {
			echo'<tr>';
			echo'<td>No result found!</td>';
			echo'</tr>';
		}
	}
#--------------------------------------------------------------------------------------

# update associated branch 
	function update_branch($conn){
		$tutionId = $_POST['tutionId'];
		$branchId = $_POST['branchId'];
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$state = mysqli_real_escape_string($conn, $_POST['state']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		$phn = mysqli_real_escape_string($conn, $_POST['phn']);
		$upd_branch = "UPDATE tbl_branch SET address = '".$address."', state = '".$state."', city = '".$city."', phone = '".$phn."' WHERE tbl_branch.branchId = '".$branchId."' AND tbl_branch.tutionId = '".$tutionId."'";
		$result = mysqli_query($conn, $upd_branch) or die('can\'t execute query!');
		echo $result.' Branch data Updated';
	}
# --------------------------------------------------------------------------------------

# insert new branch
	function insert_branch($conn){
		$tutionId = $_POST['tutionId'];	// finding no. of branche of the associated tution
			$q = "SELECT * FROM tbl_branch WHERE tutionId LIKE '".$tutionId."';";
			$result = mysqli_query($conn, $q) or die("can't count no of branche(s)!");
			$no_of_branch = mysqli_num_rows($result);

		$cnt = count($_POST['b_address']);

		for ($i=0; $i < $cnt ; $i++) { 
			$no_of_branch = $no_of_branch + 1;
			$branchId[$i] = $tutionId.'#'.$no_of_branch; // GENERATING "branchId" --> (eg. T0000001#1)
			$address[$i] = mysqli_real_escape_string($conn, $_POST['b_address'][$i]);
			//$state = $_POST['b_state'][$i]; /*state id*/
			//$city[$i] = $_POST['b_city'][$i];
			$phn[$i] = mysqli_real_escape_string($conn, $_POST['b_phn'][$i]);
		
			$q = "INSERT INTO tms.tbl_branch(branchId,tutionId,address,state,city,phone) VALUES('".$branchId[$i]."', '".$tutionId."', '".$address[$i]."', (SELECT stateName FROM `world_db`.`states` WHERE stateID = ".$_POST['b_state'][$i]."), (SELECT cityName FROM `world_db`.`cities` WHERE stateID = ".$_POST['b_state'][$i]." AND cityName like '".$_POST['b_city'][$i]."' ), ".$phn[$i].")";

			$result = mysqli_query($conn, $q) or die("can't insert branch!");
		}
			echo $cnt.' Branch inserted';

		//echo 'tutionId:> '.$tutionId.'\n branchId:> '.$branchId.'\n address:> '.$address.'\n state:> '.$state['stateName'].'\n city:> '.$city.'\n phn:> '.$phn.' ; addressL:>'.count($_POST['b_address']);
		/*$q = "INSERT INTO tbl_branch(branchId,tutionId,address,state,city,phone) VALUES('".$branchId."','".$tutionId."','".$address."','".$state."','".$city."','".$phn."')";
		$result = mysqli_query($conn, $q) or die("can't insert branch!");*/
	}
# --------------------------------------------------------------------------------------

# delete branch
	function deleteBranch($conn){
		$branchId = $_POST['branchId'];

		$q = "SELECT count(*) as totStud from tbl_student where branchId like '$branchId'";
		$students = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

		$q = "SELECT count(*) as totStaff from tbl_staff where branchId like '$branchId'";
		$staff = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

		if ($students['totStud'] == 0 && $staff['totStaff'] == 0) {
			//ON DELETE CASCADE
			$q = "DELETE FROM tbl_branch WHERE branchId LIKE '$branchId' ";
			$result = mysqli_query($conn, $q) or die(mysqli_error($conn));
			echo 1;
		}
		else{
			echo 'There are '.$students['totStud'].' Students and '.$staff['totStaff'].' Staff in this branch delete them first';
		}
	}
# --------------------------------------------------------------------------------------
	
# DYNAMICALLY CALL ONE OF THE ABOVE FUNCTION
	$func = $_REQUEST['func'];	// DYNAMIC FUNCTION SELECT FROM "fetch_tms.js"

	$func($conn); // function call
# --------------------------------------------------------------------------------------
	mysqli_close($conn);

?>