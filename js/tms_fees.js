/* FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE FEES*/
	function fillBranchSelector(){
		$form_branch_fees = $('#form_branch-fees');
		args = {'tutionId':tution,'func':'fillBranchSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/fees.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_branch_fees.html(data);
				$form_branch_fees.focus();
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT BRANCH IN "dashbord.php" -> PANE FEES */

/* FILL DROP DOWN OPTION TO SELECT STAFF IN "dashbord.php" -> PANE FEES*/
	function fillStaffSelector(){
		$form_student_fees = $('#form_student-fees');
		args = {'tutionId':tution,'func':'fillStudentSelector','branchId':$('#form_branch-fees').val()};
		//console.log(args);
		$.ajax({
			url:'../processes/fees.process.php',
			method:'POST',
			data:args,
			success:function(data){
				//alert(data);
				$form_student_fees.html(data);
			}
		});
	}
/* \.FILL DROP DOWN OPTION TO SELECT STAFF IN "dashbord.php" -> PANE FEES */

/* FETCH LAST 5 FEES PAID */
function lastFees(){
	var $fees_data_field = $('#fees_data_field');
	var args = {'tutionId':tution,'func':'lastFees'};
	$.ajax({
		url:'../processes/fees.process.php',
		method:'POST',
		data:args,
		success:function(data){
			//alert(data);
			$fees_data_field.html(data);
		}
	});
}
/* \FETCH LAST 5 FEES PAID */

/* FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */
	/*function fillStdSelector(){
		$form_std_fees = $('#form_std-fees'); 
		args = {'tutionId':tution,'func':'fillStdSelector'};
		//console.log(args);
		$.ajax({
			url:'../processes/fees.process.php',
			method:'POST',
			data:args,
			success:function(data){
				$form_std_fees.html(data);
			}
		});
	}*/
/* \.FILL DROP DOWN OPTION TO SELECT COURSE IN "dashbord.php" -> PANE STUDENT */


$('#pane_fees').ready(function(){
	
	fillBranchSelector();
	lastFees();
	// datepicker
	var currentDate = new Date();
	if (currentDate.getDate() < 10) {day = '0'+currentDate.getDate();}else{day = currentDate.getDate();}
	if (currentDate.getMonth() < 10) {month = '0'+(currentDate.getMonth()+1);}else{month = (currentDate.getMonth()+1);}
	$('#fees_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+day);
	$('#fees_date').datepicker({
		dateFormat:'yy-mm-dd',
	});

	// $('#table').dataTable();
	$('#fees_data_field').ready(function(){
		lastFees();
	});

	$('#form_student-fees').on('change',function(){
		 var args = ({'func':'fetchTotalFees','studentId':$(this).val()});
		 console.log(args);
		 $.ajax({
		 	url:'../processes/fees.process.php',
		 	method:'POST',
		 	data:args,
		 	success:function(data){
		 		console.log(data);
		 		$('#totFees').attr('value',data);
		 	}
		 });
	});

	$('#save_fees').click(function(){
		//$fees_data_field = $('#fees_data_field');
		var data = $('#fees_form .input').serializeArray();
		data.push({name:'func',value:'saveFees'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'../processes/fees.process.php',
			method:'POST',
			data:data,
			success:function(data){
				console.log(data);
				lastFees();
			}
		});
		$('#form_branch-fees').focus();
	});

	$('#form_branch-fees').on('change', function(){
		fillStaffSelector();
	});

});