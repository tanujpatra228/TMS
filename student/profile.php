<?php
session_start();

if (!isset($_SESSION['studentId'])) {
  header("Location: ../index.php");
  die();
}

$tutionId = $_SESSION['tutionId'];
$branchId = $_SESSION['branchId'];
$studentId = $_SESSION['studentId'];

// $tutionId = 'T0000001';
// $branchId = 'T0000001#1'; 
// $studentId = 'T0000001#1#1';

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

//T9324742#2#1
/*SELECT tbl_student.name,tbl_marks.* FROM `tbl_marks`, `tbl_student` 
WHERE `tbl_marks`.studentId = `tbl_student`.`studentId`
AND tbl_student.studentId LIKE 'T9324742#2#1'*/
$q = "SELECT * FROM `tbl_marks` WHERE tbl_marks.studentId LIKE '$studentId' ORDER BY `date` LIMIT 5;";
$prevMarks = mysqli_query($conn, $q) or die(mysqli_error($conn));
#----------------------------------------------------------------------------

$branchId = str_replace("#", "-", $student['branchId']);
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home | Student Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet"> -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
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

      /*$('#fees_receipt').ready(function(){
        $.ajax({
          url:'../processes/',
          method:'POST',
          data:data,
          success:function(){

          }
        });
      });*/

    });
  </script>

  <body>
    
  <?php
    include 'header.php';
  ?>

    <section class="ftco-section">
    	<div class="container">
       
	        <!--row notice board-->
	        <div class="row">
	          <div class="col-md-4 col-xs-12 offset-md-4 align-self-stretch ftco-animate">
	            <div class="media block-6 services p-3 py-4 d-block text-center">
	              <div class="icon d-flex justify-content-center align-items-center mb-3 bg-info"><span class="flaticon-blackboard" style="color: white;"></span></div>
	              <div class="media-body px-3">
	                <img src="../images/student/<?php echo $student['photo']; ?>" alt=" " style="height: 100px; width: 100px;"> <br>
	                <p> <?php echo $student['studentId']; ?> </p>
	                <p> <?php echo $student['name']; ?> </p>
	                <p> <?php echo $student['fatherName']; ?> Bhai</p>
	                <p> <?php echo $student['address']; ?> </p>
	                <p> STD <?php echo $student['std']; ?> </p>
	                <p> <?php echo $student['city']; ?> </p>
	                <p> <?php echo $student['email']; ?> </p>
	                <p> <?php echo $student['phone']; ?> </p>
	                <!-- <p> <?php echo $student['url']; ?> </p> -->
	              </div>
	            </div>      
	          </div>
	        </div>

        </div>
    </section>

    <?php
      include 'footerstud.php';
    ?>
    
  

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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>