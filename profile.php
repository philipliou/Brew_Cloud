<?php
	session_start();
	
	$pageName = "profile";
	require_once("config.php");
	require_once("utility.php");
	
	$error = NULL;
	
	$username = NULL;
	$email = NULL;
	$name = NULL;
	if (is_logged_in()) {
		$username = $_SESSION['username'];
		$email = $_SESSION['email'];
		$name = $_SESSION['name'];
	}

	oci_close($conn);
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
				<div class="span12" style="text-align: center;">
					<form action="search.php" method="GET">
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" style="height: 28px; margin: 10px 0 16px 0; padding-left: 1%; padding-right: 1%;"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php if (is_logged_in()) { ?>
				<h1><?php echo $name; ?></h1>
				<h2><?php echo $email; ?></h2>
			<?php } else { ?>
				<h2>You are not currently logged in.</h2>
			<?php } ?>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>