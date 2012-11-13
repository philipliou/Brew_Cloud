<?php
	session_start();
	
	$pageName = "index";
	require("config.php");
	
	if (isset($_GET["query"])) {
		$query = $_GET["query"];
	}
	else {
		$query = "";
	}
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
							<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" value="<?php echo $query; ?>" style="height: 28px; margin-bottom: 16px;">
								
							</input>
						</div>
						<div class="right" style="width: 5%;">
							<button class="btn search-btn" type="submit" style="height: 36px;"><i class="icon-search"></i></button>
						</div>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php if (isset($_GET["query"])) { ?>
			<div class="row">
				<div class="span2">
					<h2>Filters</h2>
				</div>
				<div class="span10">
					<h2 style="margin-bottom: 20px;">Search results for <span class="bold italic"><?php echo $query; ?></span>:</h2>
					
					<div class="well well-large">
						<h2>Budweiser</h2>
					</div>
					<div class="well well-large">
						<h2>Coors Light</h2>
					</div>
					<div class="well well-large">
						<h2>Delirium Tremens</h2>
					</div>
					<div class="well well-large">
						<h2>Budweiser</h2>
					</div>
					<div class="well well-large">
						<h2>Coors Light</h2>
					</div>
					<div class="well well-large">
						<h2>Delirium Tremens</h2>
					</div>
					<div class="well well-large">
						<h2>Budweiser</h2>
					</div>
					<div class="well well-large">
						<h2>Coors Light</h2>
					</div>
					<div class="well well-large">
						<h2>Delirium Tremens</h2>
					</div>
					<div class="well well-large">
						<h2>Budweiser</h2>
					</div>
					<div class="well well-large">
						<h2>Coors Light</h2>
					</div>
					<div class="well well-large">
						<h2>Delirium Tremens</h2>
					</div>
				</div>
			</div>
			<?php } else { ?>
			<h2>Results will be displayed below</h2>
			<?php } ?>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>