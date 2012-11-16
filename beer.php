<?php
	session_start();
	
	$pageName = "index";
	require_once("config.php");
	require_once("utility.php");
	
	$error = NULL;
	if (isset($_SESSION['error'])) {
		$error = $_SESSION['error'];
	}
	
	$_SESSION['error'] = NULL;
	
	// get beer information
	$id = NULL;
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
		$stmt = oci_parse($conn, "select name, description, msrp, abv from beers where id = ".$id);
		
		oci_execute($stmt, OCI_DEFAULT);
		$res = oci_fetch_row($stmt);
		
		$beerName = $res[0];
		$beerDescription = $res[1];
		$beerMSRP = $res[2];
		$beerABV = $res[3];
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
			<?php if ($id) { ?>
			<div class="row">
				<div class="span2">
					<img src="img/beer-image.png" alt="beer image" class="img-polaroid">
				</div>
				<div class="span8">
					<?php
					echo "<h1>".$beerName."</h1>";
					echo "<h2>".$beerDescription."<h2>";
					?>
				</div>
				<div class="span2">
					<div class="img-polaroid">
						<div class="inner-polaroid">
							<?php
							echo "<h2>MSRP: $".$beerMSRP."</h2>";
							echo "<h2>ABV: ".$beerABV."</h2>";
							?>
						</div>
					</div>
				</div>
			</div>
			<?php } else {
				echo "<h2>Please search for a beer</h2>";
			} ?>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>