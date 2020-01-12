
// Function to fill Tution data in "dashboard.php" --> pane_profile
	function fillTutionData(){
		var data = ({'func':'fetchTution','tutionId':tution});
		console.log(data);
		$.ajax({
			url:'../processes/tution.process.php',
			method:'POST',
			data:data,
			success:function(data){
				//alert(data);
				//$('#tution_data').html(data); // UNCOMMENT
			}
		});
	}
// \.Function to fill Tution data in "dashboard.php" --> pane_profile



$('#pane_prifile').ready(function(){
	
	fillTutionData();

	$('#img_logo').click(function(){
		$('#tution_logo').click();
	});

	$('#upload_image').on('change',function(){

		alert('onchange');
		var property = document.getElementById('upload_image').files[0];
		var img_name = property.name;
		var img_extension = img_name.split(".").pop().toLowerCase();
		if(jQuery.inArray(img_extension, ['png','jpeg','jpg']) == -1){
			alert('Invalid Image Type!');
		}
		var img_size = property.size;
		if(img_size > 2000000){
			alert('File to Large!');
		}
		else{
			var form_data = new FormData();
			form_data.append('file', property);
			//property.append('func','save_logo');
			console.log(form_data);

			$.ajax({
				url:'../processes/tution.process.php?func=save_logo&tutionId='+tution,
				method:'POST',
				data:form_data,
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					console.log(data);
					alert(data);
					$('#uploaded_image').html(data);
				}
				/*error:function(data){
					console.log('error');
					console.log(data);
					alert(data);
				}*/
			});
		}
	});


	var readURL = function(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('.avatar').attr('src', e.target.result);
	        }
	
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	
	$(".file-upload").on('change', function(){
	    readURL(this);
	});
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#uploaded_image').css({'background-image':'url('+e.target.result+')'});
		};

		reader.readAsDataURL(input.files[0]);
	}
}