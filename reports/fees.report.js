$(document).ready(function(){

	var currentDate = new Date();
	if (currentDate.getDate() < 10) {day = '0'+currentDate.getDate();}else{day = currentDate.getDate();}
	if (currentDate.getMonth() < 10) {month = '0'+(currentDate.getMonth()+1);}else{month = (currentDate.getMonth()+1);}

	$('#from_date').attr('value',currentDate.getFullYear()+'-'+'0'+(month-month+1)+'-'+'0'+(day-day+1));
	$('#to_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+day);

	$('#from_date').datepicker({
		dateFormat:'yy-mm-dd',
	});
	$('#to_date').datepicker({
		dateFormat:'yy-mm-dd',
	});

	$('#branch_selector').ready(function(){
		var data = ({'func':'fillBranchSelector','tutionId':tution});
		console.log(data);
		$.ajax({
			url:'fees.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#branch_selector').html(data);
			}
		});
	});

	$('#std_selector').ready(function(){
		var data = ({'func':'fillStdSelector','tutionId':tution,'calling_func':'set'});
		console.log(data);
		$.ajax({
			url:'fees.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#std_selector').html(data);
			}
		});
	});

	$('#student_selector').ready(function(){
		var data = ({'func':'fillStudentSelector','tutionId':tution,'branchId':$('#branch_selector').val(),'std':$('#std_selector').val()});
		console.log(data);
		$.ajax({
			url:'fees.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#student_selector').html(data);
			}
		});
	});

	$('#branch_selector').on('change',function(){
		var data = ({'func':'fillStudentSelector','tutionId':tution,'branchId':$('#branch_selector').val(),'std':$('#std_selector').val()});
		console.log(data);
		$.ajax({
			url:'fees.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#student_selector').html(data);
			}
		});
	});
	$('#std_selector').on('change',function(){
		var data = ({'func':'fillStudentSelector','tutionId':tution,'branchId':$('#branch_selector').val(),'std':$('#std_selector').val()});
		console.log(data);
		$.ajax({
			url:'fees.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#student_selector').html(data);
			}
		});
	});

	$('#btn_search').click(function(){
		if ($('#student_selector').val() == 0) {
			alert('Select Student');
		}
		else{
			var data = $('.input').serializeArray();
			data.push({name:'func',value:'searchStudent'},{name:'tutionId',value:tution});
			console.log(data);
			$.ajax({
				url:'fees.php',
				method:'POST',
				data:data,
				success:function(data){
					//alert(data);
					$('#content').html(data);
				}
			});
		}
	});
});