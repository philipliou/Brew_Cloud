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
		$stmt = oci_parse($conn, "select B.name, B.description, B.msrp, B.abv, M.name from beers B, manufacturers M where B.manufacturerid = M.id and B.id = ".$id);
		
		oci_execute($stmt, OCI_DEFAULT);
		$res = oci_fetch_row($stmt);
		
		$beerName = $res[0];
		$beerDescription = $res[1];
		$beerMSRP = $res[2];
		$beerABV = $res[3];
		$manufacturer = $res[4];
	}
	
	$postedReview = FALSE;
	$blank = NULL;
	
	include("review.php");
	
	if (is_logged_in()) {
		$userid = $_SESSION['id'];
		$stmt = oci_parse($conn, "select R.userid from reviews R where R.userid = ".$userid." AND R.beerid = ".$id);
		
		oci_execute($stmt, OCI_DEFAULT);
		if ($res = oci_fetch_row($stmt)) {
			$postedReview = TRUE;
		}
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
	<script src="scripts/beer-review.js" type="text/javascript"></script>
</head>
<body>
	<div class="wrapper">
		<?php include("header.php"); ?>
	
		<div class="container">
			<div style="height: 52px;"></div>
			
			<div class="row">
				<div class="span12" style="text-align: center;">
					<form action="search.php" method="GET">
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" style="height: 36px; font-size: 16px; margin: 10px 0 16px 0; padding-left: 1%; padding-right: 1%;"></input>
						<input type="hidden" name="sort_by" value="default"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php if ($id) { ?>
			<div class="row">
				<div class="span2">
					<img src="img/beer-image.png" alt="beer image" class="img-polaroid">
				</div>
				<div class="span7">
					<div>
					<?php
					echo '<h1 style="margin-bottom: 2px;">'.$beerName.'</h1>';
					echo '<p style="margin-left: 1px; margin-top: 0;">'.$manufacturer.'</p>';
					echo '<h2 style="margin-left: 1px;">'.$beerDescription.'<h2>';
					?>
					</div>
					<div class="reviews">
						<h1 style="float: left;">Reviews</h1>
						<?php if (is_logged_in() && !($postedReview)) { ?>
							<button id="show-review" class="btn btn-small btn-warning">Post Review</button>
						<?php } ?>
						<div style="clear: both; height: 16px;"></div>
						<?php if ($blank) { echo "<p>".$blank."</p>"; } ?>
						<div id="review-input">
							<form action="<?php echo getPageURL(); ?>" method="POST">
								<select name="rating">
									<option value="5">5 stars</option>
									<option value="4">4 stars</option>
									<option value="3">3 stars</option>
									<option value="2">2 stars</option>
									<option value="1">1 star</option>
								</select>
								<textarea name="review" placeholder="Write your thoughts here"></textarea>
								<button id="submit-review" class="btn btn-small btn-warning">Submit Review</button>
							</form>
							<div style="clear: both; height: 16px;"></div>
						</div>
						
						<?php
							$count = 0;
							$sql = "SELECT E.firstname, E.lastname, R.rating, R.description FROM Reviews R, Endusers E WHERE R.userid = E.id AND R.beerid = ".$id." ORDER BY lastupdated DESC";
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							
							while ($res = oci_fetch_row($stmt)) {
								$count++;
								echo '<div class="review-entry well">';
								echo '<p class="title">'.$res[0].' '.$res[1].'</p>';
								if ($res[2] == 1) {
									echo '<p class="rating">Rating: '.$res[2].' star</p>';
								}
								else {
									echo '<p class="rating">Rating: '.$res[2].' stars</p>';
								}
								echo '<p>'.$res[3].'</p>';
								echo '</div>';
							}
							
							if ($count == 0) {
								echo "<h2>Be the first to review this beer</h2>";
							}
						?>
					</div>
				</div>
				<div class="span3">
					<div class="img-polaroid" style='margin-bottom: 10px'>
						<div class="inner-polaroid">
							<?php
							$sql = "SELECT AVG(R.rating), COUNT(*) FROM Reviews R WHERE R.beerid = ".$id;
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							
							if ($res = oci_fetch_row($stmt)) {
								if ($res[1] > 0) {
									echo '<h1 style="font-size: 48px; margin-top: 16px; margin-bottom: 12px;">'.number_format($res[0], 2).'</h1>';
								}
							}
							
							if ($res[1] > 0) {
								echo '<div style="margin-left: 2px;">';
								if ($res[1] == 1) {
									echo "<p>".$res[1]." Review</p>";
								}
								else {
									echo "<p>".$res[1]." Reviews</p>";
								}
							}
							else {
								echo '<h1 style="font-size: 48px; margin-top: 16px; margin-bottom: 12px;">NR</h1>';
								echo '<div style="margin-left: 2px;">';
								echo "<p>No Reviews</p>";
							}
							
							$sql = "SELECT BS.description FROM Beers B, BeerStyles BS WHERE B.beerstyleid = BS.id AND B.id = ".$id;
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							
							if ($res = oci_fetch_row($stmt)) {
								$beerStyle = $res[0];
								echo '<h2><span class="bold">Style:</span> '.$beerStyle.'</h2>';
							}

							echo '<h2><span class="bold">MSRP:</span> $'.$beerMSRP.'</h2>';
							echo '<h2><span class="bold">ABV:</span> '.$beerABV.'%</h2>';
							echo "</div>";
							?>
						</div>
					</div>
					<div class="img-polaroid">
						<div class="inner-polaroid">
							<h1> Available At: </h1>
							<?php
							$sql = 'select BARS.resellerid, R.name from beers B, bars BARS, resellers R, availability A where BARS.resellerid = R.id AND A.resellerid = R.id AND A.beerid = B.id AND B.id = 1120';
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							echo "<h2 style='font-weight: 700;'> Bars </h3>";
							if ($res = oci_fetch_row($stmt)) {
								$barID = $res[0];
								$barNAME = $res[1];
								echo '<p>' . $barNAME . '</p>'; 
							}
							?>
							<?php
							$sql = 'SELECT RT.resellerid, R.name, S.name FROM beers B, retailstores RT, resellers R, availability A, storetypes S WHERE S.id = RT.storetypeid AND RT.resellerid = R.id AND A.resellerid = R.id AND A.beerid = B.id AND B.id = '. $id;
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT);
							echo "<h2 style='font-weight: 700;'> Retail Stores </h3>";
							if ($res = oci_fetch_row($stmt)) {
								$rtID = $res[0];
								$rtName = $res[1];
								$storeType = $res[2];
								echo '<p>' . $rtName . ' (' . $storeType . ')</p>'; 
							}
							oci_close($conn);
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