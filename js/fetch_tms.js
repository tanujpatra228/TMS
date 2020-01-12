// SHOW BRANCHES IN PANE BRANCH "dashbord.php"
function showBranch(){
	//alert('showBranch() call');
	$.ajax({
		url:"../processes/fetch.php",
		method:"GET",
		data:'tutionId='+tution+'&func=fetch_all_branch', // "tution" from dashbord.php
		success:function(data){
			//alert(data);
			$branches.html(data);
		  }
	});
}
// \.SHOW BRANCHES IN PANE BRANCH

// EDIT BUTTON IN PANE BRANCH "dashbord.php"
function makeEditable(rel){
	// rel = "id" of <tr> in pane_branch in dashbord.php
	$branch = $branches.find(rel);
	$(rel+' td input').each(function(){
		$(this).attr('disabled',false);
	});
	
	$button = $branch.find('.btn-info'); // $button = <tbody> -> <tr> -> <td> -> <button> "dashbord.php"
	$glyphicon = $button.find('.glyphicon'); // $button = <tbody> -> <tr> -> <td> -> <button> -> <span>"dashbord.php"
	
	$button.attr('onclick','updateBranch(\''+rel+'\');');
	
	$glyphicon.removeClass('glyphicon-edit');
	$glyphicon.addClass('glyphicon-floppy-disk');
}
// \.EDIT BUTTON IN PANE BRANCH

// UPDATE BRANCH DATA IN DATABASE
function updateBranch(rel){ // rel = "id" of <tr> in pane_branch in dashbord.php
	inputs = $(rel+' td input').serializeArray();
	inputs.push({name:'func', value:'update_branch'},{name:'tutionId',value:tution});
	
	$.ajax({
		url:'../processes/fetch.php',
		method:'POST',
		data:inputs,
		success:function(data){
			swal("Done",data,"success");
		}
	});

	showBranch();
}	
// \.UPDATE BRANCH DATA IN DATABASE

// INSERT NEW BRANCH IN DATABASE
function insertBranch(){
	inputs = $('#tbl_add_branch .input').serializeArray();
	inputs.push({name:'func', value:'insert_branch'},{name:'tutionId',value:tution});
	//console.log(inputs);
	
	$.ajax({
		url:'../processes/fetch.php',
		method:'POST',
		data:inputs,
		success:function(data){
			swal("Done",data,"success");
		}
	});

	showBranch();
}
// \.INSERT NEW BRANCH IN DATABASE

// DELETE BRANCH PERMANENTLY (INCOMPLETE) [no one should delete any branch before it has no students or staff]
function deleteBranch(branch,address,state,city,phn){
	var r = confirm('Do you really want to remove this branch?\n ---------------------------------------------\n Address:> '+address+'\n State:> '+state+'\n City:> '+city+'\n Phone no.:> '+phn);

	if(r){
		//alert('delete action');
		var data = ({'branchId':branch,'func':'deleteBranch'});
		console.log(data);
		$.ajax({
			url:'../processes/fetch.php',
			method:'POST',
			data:data,
			success:function(data){
				if (data == 1){
					swal("Done",data,"success");
				}
				else{
					swal("Warning",data,"warning");
				}
			}
		});
	}else{
		alert('delete cancel');
	}
}
// \. DELETE BRANCH PERMANENTLY

$(document).ready(function(){
	$branches = $('#branches'); // $branch = <table> -> <tbody> "dashbord.php"

	$branches.ready(function(){
		showBranch();
	});
});