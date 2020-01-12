$(document).ready(function(){
	/*$.ajax({
		url: "http://localhost/TYproject/includes/print_jason.php",
		method: "GET",
		success: function(data){
			console.log(data);
			var city_id = [];
			var city = [];

			for (i in data) {
				city_id.push("City_ID "+ data[i].city_id);
				city.push("City "+ data[i].city);
			}

			var chartData = {
				labels: city,
				datasets: [
					{
						label: "City ID",
						backgroundColor: 'rgba(200,200,200,0.75)',
						hoverBackgroundColor: 'rgba(200,200,200,1)',
						hoverBorderColor: 'rgba(200,200,200,1)',
						data: city
					}
				]
			};

			var ctx = $('#chart1');
			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartData
			});
		},
		error: function(data){
			console.log(data);
		}
	});*/

	$('#yearly_income').ready(function(){
		var data = ({'func':''});
		$.ajax({
			url:'',
			method:'POST',
			data:data,
			success:function(){

			}
		});

		Chart.defaults.global.responsive = false;
		var yearly_income = $('#yearly_income');
		console.log(yearly_income);
		var chart = new Chart(yearly_income,{
			type:'line',
			data: {
		        labels: ['January', 'Febuary', 'March','April'],
		        datasets: [{
		            label: 'Expected Monthly Income',
		            data: [10333, 10333, 10333, 10333],
		            lineTension: 0.1,
		            backgroundColor: 'rgba(0, 204, 255, 0.5)',
		            pointHoverBackgroundColor: 'rgba(0, 204, 255, 1)'
		        },{
		            label: 'Expected Monthly Expenses',
		            data: [4818, 4818, 4818, 4818],
		            lineTension: 0.1,
		            backgroundColor: 'rgba(236, 168, 18, 0.5)',
		            pointHoverBackgroundColor: 'rgba(236, 168, 18, 1)'
		        },{
		            label: 'Monthly Income',
		            data: [3000, 2000, 3050, 0],
		            lineTension: 0.1,
		            backgroundColor: 'rgba(0, 204, 255, 0.8)',
		            pointHoverBackgroundColor: 'rgba(0, 204, 255, 1)'
		        },{
		            label: 'Monthly Expenses',
		            data: [2041.25, 2000.25, 3200, 1501.25],
		            lineTension: 0.1,
		            backgroundColor: 'rgba(236, 168, 18, 0.8)',
		            pointHoverBackgroundColor: 'rgba(236, 168, 18, 1)'
		        }]
		    },
		    options: {
		    	scales:{
		    		yAxes: [{
		    			ticks:{
		    				beginAtZero: true,
		    				
		    			}
		    		}]
		    	}
		    }
		});
	});

});