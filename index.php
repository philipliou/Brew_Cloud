<?php
	session_start();
	
	$pageName = "index";
	require("config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link href="css/bootstrap.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.css" rel="stylesheet" />
	<link href="css/style.css?a1" rel="stylesheet" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="scripts/jquery.placeholder.min.js" type="text/javascript"></script>
	<script src="scripts/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
	<div class="wrapper">
		<?php include("header.php"); ?>
	
		<div class="container">
			<div style="height: 52px;"></div>
			
			<div class="row">
				<div class="span12">
					<form action="search.php" method="GET">
						<div class="left" style="width: 93%;">
							<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" style="height: 28px; margin-bottom: 16px;"></input>
						</div>
						<div class="right" style="width: 5%;">
							<button class="btn search-btn" type="submit" style="height: 36px;"><i class="icon-search"></i></button>
						</div>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php include("main.php"); ?>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>