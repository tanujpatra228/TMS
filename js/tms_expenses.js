$('#pane_expenses').ready(function(){
	fetchExpenses();

	$('#pane_expenses #display_exp_ins_tbl').click(function(){
		$('#ins_expenses_div').slideToggle();
		scrollToggle();
		$('#exp1_branch').focus();
	});

	$('#expenses_data_tbody').ready(function(){
		fetchExpenses();
	});

	//$('#expenses_data').DataTable();
	/*$('#expenses_data').DataTable({
		responsive: {
		           details: {
		               display: $.fn.dataTable.Responsive.display.modal( {
		                   header: function ( row ) {
		                       var data = row.data();
		                       return 'Details for '+data[0]+' '+data[1];
		                   }
		               } ),
		               renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
		                   tableClass: 'table'
		               } )
		           }
		       }
	});*/	// datatable plugin

	temp = true;	// Flag for function scrollToggle()
	add_exp_flag = true;
	function scrollToggle(){
		if(temp){
			$('#expenses_form_container').css({'overflow-x':'scroll'});
			temp = false;
			if(add_exp_flag){
				add_expenses();
				add_exp_flag = false;
			}
		}
		else{
			$('#expenses_form_container').css({'overflow-x':'hidden'});
			temp = true;
		}
	}

});

function insertExpense(){
	var data = $('#expenses_form .input').serializeArray();
	
	var date = new Date();
	var day = date.getDate();
	var month = date.getMonth();
	if (date.getDate()<10) {day = '0'+date.getDate();}else{day = date.getDate();}
	if (date.getMonth()<10) {month = '0'+(date.getMonth()+1);}else{month = (date.getMonth()+1);}

	date = date.getFullYear()+'-'+month+'-'+day;
	data.push({name:'func',value:'addExpense'},{name:'tutionId',value:tution},{name:'date',value:date});
	console.log(data);
	$.ajax({
		url:'../processes/expenses.process.php',
		method:'POST',
		data:data,
		success:function(data){
			//alert(data);
			if (data != 0){
				swal("Done",data,"success");
				fetchExpenses();
			}
			else{
				swal("Hmm!", data,"error");
			}
			//$('#expenses_data_tbody').html(data);
			//$('#resetbtn_expenses_form').click();
		}
	});
}

function fetchExpenses(){
	var data = ({'func':'fetchExpense','tutionId':tution});
	console.log(data);
	$.ajax({
		url:'../processes/expenses.process.php',
		method:'POST',
		data:data,
		success:function(data){
			//alert(data);
			$('#expenses_data_tbody').html(data);
		}
	});
	//$('#expenses_data').dataTable();
}

// EDIT BUTTON IN PANE BRANCH "dashbord.php"
function makeEditable(rel){
	// rel = "id" of <tr> in pane_branch in dashbord.php
	$tr = $('#expenses_data_tbody').find(rel);
	$(rel+' td input').each(function(){
		$(this).attr('disabled',false);
	});
	
	$button = $tr.find('.btn-info'); // $button = <tbody> -> <tr> -> <td> -> <button> "dashbord.php"
	$glyphicon = $button.find('.glyphicon'); // $button = <tbody> -> <tr> -> <td> -> <button> -> <span>"dashbord.php"
	
	$button.attr('onclick','updateBranch(\''+rel+'\');');
	
	$glyphicon.removeClass('glyphicon-edit');
	$glyphicon.addClass('glyphicon-floppy-disk');
}
// \.EDIT BUTTON IN PANE BRANCH

// UPDATE BRANCH DATA IN DATABASE
function updateBranch(rel){ // rel = "id" of <tr> in pane_branch in dashbord.php
	inputs = $(rel+' td input').serializeArray();
	inputs.push({name:'func', value:'updateExpense'},{name:'tutionId',value:tution},{name:'expId',value:'exp_id'});
	console.log(inputs);
	$.ajax({
		url:'../processes/expenses.process.php',
		method:'POST',
		data:inputs,
		success:function(data){
			if (data != 0) {
				swal("Done",data,"success");
				fetchExpenses();
			}
			else{
				swal("Hmm!",data,"error");
			}
		}
	});
}	
// \.UPDATE BRANCH DATA IN DATABASE

function deleteExpense(id){
	inputs = ({'func':'deleteExpense','expenseId':id});
	console.log();
}