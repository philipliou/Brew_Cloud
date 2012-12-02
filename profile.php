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
		$id = $_SESSION['id'];
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
				<div class="span12" style="text-align: center;">
					<form action="search.php" method="GET">
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" style="height: 36px; font-size: 16px; margin: 10px 0 16px 0; padding-left: 10px; padding-right: 10px;"></input>
						<input type="hidden" name="sort_by" value="default"></input>
						<input type="hidden" name="rating" value="0"></input>
						<input type="hidden" name="reviews" value="0"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<div class="row">
				<div class="span2" style="margin-top: 3px;">
					<?php if (is_logged_in()) { ?>
						<h1><?php echo $name; ?></h1>
						<h2><?php echo $email; ?></h2>
					<?php } else { ?>
						<h2>You are not currently logged in.</h2>
					<?php } ?>
				</div>
				<div class= "span10">
					<div class="reviews" style="border: none; margin-top: 0;">
						<h1 style="margin-top: 0;">My Reviews</h1>
						<div style="clear: both; height: 16px;"></div>
						
						<?php
							$sql = "SELECT B.id, B.name, R.rating, R.description FROM Reviews R, Beers B WHERE R.beerid = B.id AND R.userid = ".$id." ORDER BY lastupdated DESC";
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							
							while ($res = oci_fetch_row($stmt)) {
								echo '<div class="review-entry well">';
								echo '<a href="beer.php?id='.$res[0].'"><p class="title">'.$res[1].'</p></a>';
								if ($res[2] == 1) {
									echo '<p class="rating">Rating: '.$res[2].' star</p>';
								}
								else {
									echo '<p class="rating">Rating: '.$res[2].' stars</p>';
								}
								echo '<p>'.$res[3].'</p>';
								echo '</div>';
							}

							oci_close($conn);
						?>
					</div>
				</div>
			</div>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>