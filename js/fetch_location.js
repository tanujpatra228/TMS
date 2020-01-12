
// Fetching States from fetch_states.php---------------------------------------------------
function fetchStates(str,ele){	
	 var xhttp;
	 //alert('fetchStates call');
	 if (window.XMLHttpRequest)
	 {
	   		// code for modern browsers
   	 	xhttp = new XMLHttpRequest();
	 }
	 else
	 {
	   		// code for IE6, IE5
	 	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	 }

	xhttp.open("GET","http://localhost/TYproject/includes/fetch_states.php?country="+str,true);
	xhttp.send();
	xhttp.onreadystatechange=function(){
		//alert("xhttp.status="+xhttp.readyState+" xhttp.status="+xhttp.status);
		if(xhttp.readyState==4 && xhttp.status==200)
		{
			//alert($('#'+ele).attr('id'));
			//document.getElementById("class_state").innerHTML=xhttp.responseText;
			$('#'+ele).append(xhttp.responseText);
			
		}
	}
}
//-----------------------------------------------------------------------------------------


// Fetching cityes from fetch_cities.php---------------------------------------------------
function fetchCities(state,result_ele)
{	
	//console.log('$(\'#'+result_ele+')+.html(xhttp.responseText)');
		 var xhttp;
		 if (window.XMLHttpRequest)
		 {
		   		// code for modern browsers
	   	 	xhttp = new XMLHttpRequest();
		 }
		 else
		 {
		   		// code for IE6, IE5
		 	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		 }
		
		xhttp.open("GET","http://localhost/TYproject/includes/fetch_cities.php?state="+state,true);
		xhttp.send();
		xhttp.onreadystatechange=function()
		{
			//alert("xhttp.status="+xhttp.readyState+" xhttp.status="+xhttp.status);
			if(xhttp.readyState==4 && xhttp.status==200)
			{
				//alert(xhttp.responseText);
				//document.getElementById("class_city").innerHTML = xhttp.responseText;
				// $('#'+result_ele).html(xhttp.responseText);
				$('#'+result_ele).html(xhttp.responseText);
			}
		}
}
//-----------------------------------------------------------------------------------------