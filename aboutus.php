<html>
<head>

<title>About Us | TMS</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

<style type="text/css" rel="stylesheet">
	#col{margin-left: 300px;}
</style>

</head>
	<body>
		<!-- Header -->
		<header class="bg-info text-center py-3 mb-4">
			<?php
      			include'navbar.php';
    		?> 
			<div class="container mt-5">
				<h1 class="font-weight-light text-white">Our Team Members</h1>
			</div>
		</header>


		<!-- Page Content -->
		<div class="container">
			<div class="row">
			<!-- Team Member 1 -->
					<div class="col-xl-6 col-md-12 mb-4">
						<div class="card border-0 shadow">
							<img src="https://source.unsplash.com/TMgQMXoglsM/500x350" class="card-img-top" alt="...">
							<div class="card-body text-center">
								<h5 class="card-title mb-0">Tanuj Patra</h5>
								<div class="card-text text-black-50">PHP Developer</div>
							</div>
						</div>
					</div>
				<!-- Team Member 2 -->
				<div class="col-xl-6 col-md-12 mb-4">
					<div class="card border-0 shadow">
						<img src="https://source.unsplash.com/9UVmlIb0wJU/500x350" class="card-img-top" alt="...">
						<div class="card-body text-center">
							<h5 class="card-title mb-0">Rima Sing</h5>
							<div class="card-text text-black-50">Web Developer</div>
						</div>
					</div>
				</div>
				
			</div>
			<!-- /.row 1-->

			<!-- Team Member 3 -->
			<div class="row"> 
				<div class="col-xl-6 col-md-12 mb-4" id="col">
					<div class="card border-0 shadow">
						<img src="https://source.unsplash.com/sNut2MqSmds/500x350" class="card-img-top" alt="...">
						<div class="card-body text-center">
							<h5 class="card-title mb-0">Rohan Gavali</h5>
							<div class="card-text text-black-50">Web Developer</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.row 2 -->
		</div>
		<!-- /.container -->

		<!-- FOOTER -->
      	<?php
          include'footer.php';
        ?>
	</body>
</html>


