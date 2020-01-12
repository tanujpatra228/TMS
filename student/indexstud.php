<?php
session_start();

if (!isset($_SESSION['studentId'])) {
  header("Location: ../index.php");
  die();
}

$tutionId = $_SESSION['tutionId'];
$branchId = $_SESSION['branchId'];
$studentId = $_SESSION['studentId'];


include'../includes/connect.inc.php';
$conn = connection('tms');
#----------------------------------------------------------------------------

# FETCH STUDENT, TUTION, BRANCH, MARKS AND ATTENDENCE DATA
$q = "SELECT * FROM tbl_student WHERE studentId LIKE '$studentId'";
$student = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

$q = "SELECT * FROM tbl_tution WHERE tutionId LIKE '$tutionId'";
$tution = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

$q = "SELECT COUNT(*) AS days FROM tbl_attendence WHERE tbl_attendence.id LIKE '$studentId'";
$totPresent = mysqli_fetch_array(mysqli_query($conn, $q)) or die(mysqli_error($conn));

$q = "SELECT * FROM `tbl_marks` WHERE tbl_marks.studentId LIKE '$studentId' ORDER BY `date` LIMIT 5;";
$prevMarks = mysqli_query($conn, $q) or die(mysqli_error($conn));
#----------------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>TMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <!-- <link rel="stylesheet" href="css/bootstrap-datepicker.css"> -->
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <?php echo'<script type="text/javascript">tution = "'.$tutionId.'"</script>'; ?>
    <?php echo'<script type="text/javascript">branch = "'.$branchId.'"</script>'; ?>
    <?php echo'<script type="text/javascript">student = "'.$studentId.'"</script>'; ?>
  </head>

  <style type="text/css">
    #ftco-nav{
      background: transparent;
    }
    #navbar-dark{
    }
    table{
      font-size: 16px;
    }
  </style>
  <script type="text/javascript">
    function fetchNotice(){
      var data = ({'func':'fetch_notice','tutionId':tution,'type':'student'});
      console.log(data);
      $.ajax({
        url:'../processes/notice.process.php',
        method:'POST',
        data:data,
        success:function(data){
          if (data != 0){
            $('#notice_board').html(data);
          }
          else{
            $('#notice_board').html('<h4 class="alert-heading">Nothing!</h4> <p>No message yet.</p><hr> <p class="mb-0 text-right" style="font-size: 13px;line-height: 1;">0000-00-00<br/><small>00:00:00</small></p>'); }
        }
      });
    }
    $(document).ready(function(){
      $('#notice_board').ready(function(){
        fetchNotice();
      });
      setInterval(fetchNotice,10000);

      $('#attendence').ready(function(){
        var d = new Date();
        var day = new Date(d.getFullYear(),d.getMonth());

        var start_date = day.getFullYear()+'-'+day.getMonth()+'-'+day.getDate();
        var end_date = d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate();
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $("#month").html(d.getDate()+' '+months[d.getMonth()]);
        //$('#attendence').html(d.getDate()-1 +'/'+d.getDate());

        var data = ({'prev_date':start_date,'end_date':end_date,'func':'fetchAttendence','studentId':student});
        console.log(data);
        $.ajax({
          url:'../processes/attendence.process.php',
          method:'POST',
          data:data,
          success:function(data){
            $('#attendence').html(data +'/'+d.getDate());
          }
        });
      });
    });
  </script>
  <body>
  	<?php  
  		include("header.php");
  	?>

    <section class="ftco-section">
  
      <div class="col-md-4 d-flex align-self-stretch ftco-animate text-center" style="padding-left: 50px;">
        
        <div class="media block-6 services p-3 py-4 d-block text-center">
          <div class="icon d-flex justify-content-center align-items-center mb-3"><span class="flaticon-blackboard"></span></div>
          <div class="media-body px-5">
            <div class="alert alert-primary" role="alert" id="notice_board">
              <h4 class="alert-heading">Well done!</h4>
              <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
              <hr>
              <p class="mb-0 text-right" style="font-size: 13px;line-height: 1;">2019-04-05<br/><small>20:22:59</small></p>
            </div>
          </div>
        </div>      
      
      </div>

    </section>


    <section class="ftco-section">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 col-xs-12 heading-section ftco-animate text-center">
            <h2 class="mb-4">Reports</h2>
          </div>
        </div>
    		<div class="row text-center">
    			<div class="col-md-6 col-sm">
    				<div class="course align-self-stretch">
    					<div class="text p-4">
    						<p class="category"><span>Report</span></p>
    						<h3 class="mb-3"><a href="#">Marks Report</a></h3>
    						<table class="table table-striped text-center table-responsive">
    							<thead>
                    <tr>
                      <th>Date</th>
                      <th>Eng</th>
                      <th>Grammer</th>
                      <th>Maths</th>
                      <th>Sci</th>
                      <th>SS</th>
                      <th>Computer</th>
                      <th>Hindi</th>
                    </tr>       
                  </thead>
                  <tbody>
                    <?php
                      foreach ($prevMarks as $marks) {
                        echo'<tr>';
                        echo'<td>'.$marks['date'].'</td>';
                        echo'<td>'.$marks['eng1'].'</td>';
                        echo'<td>'.$marks['gramer'].'</td>';
                        echo'<td>'.$marks['maths'].'</td>';
                        echo'<td>'.$marks['sci'].'</td>';
                        echo'<td>'.$marks['ss'].'</td>';
                        echo'<td>'.$marks['computer'].'</td>';
                        echo'<td>'.$marks['hindi'].'</td>';
                        echo'</tr>';
                      }
                    ?>
                  </tbody>
    						</table>
    						<br>
    						<!--<p><a href="#" class="btn btn-primary">Enroll now!</a></p>-->
    					</div>
    				</div>
    			</div>

          <div class="col-md-6 col-sm-12 d-block ftco-animate">
            <div class="course align-self-stretch">
              <div class="text p-4">
                <p class="category"><span>Report</span></p>
                <h3 class="mb-3" style="display: inline-block;"><a href="#">Attendence Report</a></h3>&nbsp;&nbsp;&nbsp;<span class="lead" id="month"></span>
                <br>
                  <h1 class="display-4" id="attendence"></h1>
                <!--<p><a href="#" class="btn btn-primary">Enroll now!</a></p>-->
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>

    
    <?php 
    	include("../footer.php");
     ?>
    
  <style type="text/css">
    .table td,.table th{
      padding: 5px;
    }
  </style>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/bootstrap-datepicker.js"></script>
  <script src="js/jquery.timepicker.min.js"></script>
  <script src="js/scrollax.min.js"></script>
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> -->
  <!-- <script src="js/google-map.js"></script> -->
  <script src="js/main.js"></script>
    
  </body>
</html>