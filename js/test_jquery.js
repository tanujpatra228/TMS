$(document).ready(function(){

	/*$('#btnadd').click(function(){
		$('#input-area').append('<input type="text" name="text3" />');
		console.log('added');
	});*/

	n = 0;
	$("#btnadd").click(function(){
		n=n+1;
		console.log(n); 
		$('form').append('<div class="row"><div class="col-xs-6 col-sm-6 col-md-6"><div class="form-group"><input type="password" name="pwd'+n+'" class="form-control input-sm" placeholder="Password'+n+'" /><span class="alert-warning col-md-12" style="font-size: 9px;"><strong>NOTE! :</strong> This Password will be used to log you in to your Dashbord.</span></div></div><div class="col-xs-6 col-sm-6 col-md-6"><div class="form-group"><input type="password" name="re-pwd'+n+'" class="form-control input-sm" placeholder="Re-type Password'+n+'" /></div></div></div>');
	});
});
