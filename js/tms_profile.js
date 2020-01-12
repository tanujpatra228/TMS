/*Fetch tution and admin data and show in Form */ 
function fetchData(){
	var data = {'func':'fetchData','tutionId':tution,'userType':userType};
	//console.log(data);
	$.ajax({
		url:'../processes/profile.process.php',
		data:data,
		method:'POST',
		success:function(data){
			$('#tution_data').html(data);
			/*console.log($('#btn_tution_save'));
			save_btn = $('#btn_tution_save');*/
		}
	});
}
/* \ Fetch tution and admin data and show in Form */

/* UPDATE PROFILE DATA*/
function updateData(photo){
	var data = $('#form_tution_profile .input').serializeArray();
	data.push({name:'func',value:'updateData'},{name:'tutionId',value:tution},{name:'userType',value:userType});
	//console.log(data);

	$.ajax({
		url:'../processes/profile.process.php',
		data:data,
		method:'POST',
		success:function(data){
			//$('#tution_data').html(data);
			swal("Update","successful","success");
		}
	});
}
/* \ UPDATE PROFILE DATA*/

/*UPDATE LOGO*/
function updateLogo(photo){
	var data = new FormData();
	data.append('tution_logo',photo.files[0]);
	data.append('func','updateLogo');
	//console.log(data);
	readURL(photo);
	// Photo upload
	$.ajax({
	   url: "../processes/profile.process.php?tutionId="+tution,
	   type: "POST",
	   data: data,// new FormData(this),
	   contentType: false,
	   cache: false,
	   processData:false,
	   success: function(data){
	   		//alert(data);
	   		if (data != 0){
	   			$('#img_logo').attr('src',data);
	   			fetchData();
	   			swal("Great","Logo updated","success");
	   		}
	   		else{
	   			swal("Error!","File Extention not Valid.","error");
	   			fetchData();
	   		}
	   }
	});
}
/* \UPDATE LOGO */

/*LOGO PREVIEW */
function readURL(input) {
	//console.log(input.files[0]);
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		//console.log(reader);
		reader.onload = function (e) {
			//$('#img_logo').css({'background-image':'url('+ e.target.result+')'});
			$('#img_logo').attr('src',e.target.result);
			//console.log(e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	}
}
/* \LOGO PREVIEW */


$('#pane_profile').ready(function(){
	fetchData();
});