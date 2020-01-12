/* FETCH EXPENSE */
	function fetchExpense(){
		var data = $('#ie_report_form').serializeArray();
		data.push({name:'func',value:'fetchExpense'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'income_expense.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#expense_table').html(data);
			}
		});
	}
/* \FETCH EXPENSE */

/* FETCH INCOME */
	function fetchIncome(){
		var data = $('#ie_report_form').serializeArray();
		data.push({name:'func',value:'fetchIncome'},{name:'tutionId',value:tution});
		console.log(data);
		$.ajax({
			url:'income_expense.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				$('#income_table').html(data);
			}
		});
	}
/* \FETCH INCOME */


$(document).ready(function(){
	
	var currentDate = new Date();
	if (currentDate.getDate() < 10) {day = '0'+currentDate.getDate();}else{day = currentDate.getDate();}
	if (currentDate.getMonth() < 10) {month = '0'+(currentDate.getMonth()+1);}else{month = (currentDate.getMonth()+1);}

	//$('#from_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+'0'+(day-day+1));
	//$('#to_date').attr('value',currentDate.getFullYear()+'-'+month+'-'+day);

	$('#from_date').datepicker({
		dateFormat:'yy-mm-dd',
	});
	$('#to_date').datepicker({
		dateFormat:'yy-mm-dd',
	});

	// fetchIncome();
	// fetchExpense();

	$('#btn_search').click(function(){
		fetchIncome();
		fetchExpense();
	});

});