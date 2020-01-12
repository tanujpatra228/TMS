<?php
$date = date("m");
echo $date;

?>
<!DOCTYPE html>
<html>
<head>

	<title></title>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta charset="utf-8"> 
	
    <!-- jQuery CDN -->
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- \.jQuery CDN -->

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- \.Bootstrap CDN -->

</head>
<body>
	<div class="container">
    	<header>
    	</header>

    	<section>
           <form action="fsins.php" method="POST">
            <input type="email" name="email">
             <input type="submit" name="submit"/>
           </form>
    	</section>
    	<footer>
    	</footer>
	</div>
</body>
</html>