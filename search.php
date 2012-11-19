<?php
	session_start();
	
	$pageName = "index";
	require_once("config.php");
	require_once("utility.php");
	
	$query = NULL;
	if (isset($_GET["query"])) {
		$query = strtolower($_GET["query"]);
		$query = filter_var($query, FILTER_SANITIZE_SPECIAL_CHARS);
	}
	
	if (isset($_GET["sort_by"])) {
		$sort_by = strtolower($_GET["sort_by"]);
	}
	else {
		$sort_by = "default";
	}
	
	$error = NULL;

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
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" value="<?php echo $query; ?>" style="height: 36px; font-size: 16px; margin: 10px 0 16px 0; padding-left: 1%; padding-right: 1%;"></input>
						<input type="hidden" name="sort_by" value="default"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php if (isset($_GET["query"]) && $query) { ?>
			<div class="row">
				<div class="span12">
					<h2 style="margin-bottom: 20px;">
						<span class='bold'>
							<?php 	
							$sql = "SELECT COUNT(*) FROM Beers B WHERE CATSEARCH(B.NAME, '(" . $query . ")', NULL) >0";
							$stmt = oci_parse($conn, $sql);
							oci_execute($stmt, OCI_DEFAULT); 
							while($res = oci_fetch_row($stmt)) {
							echo $res[0];
							}
							?>
						</span> search results for <span class="bold"><?php echo $query; ?></span>:</h2> 
							<div id="search-results"> 
								<ul>
									<li style='line-height: 26px; font-weight: 700;'>Sort by</li>
									<li>
										<form action= "search.php" method="GET">
											<button type="submit" class="btn btn-small btn-warning">Name</button>
											<input type="hidden" name="query" value="<?php echo $query ?>"></input>
											<input type="hidden" name="sort_by" value="name"></input>
										</form>
									</li>
									<li>
										<form action= "search.php" method="GET">
											<button type="submit" class="btn btn-small btn-warning">Rating</button>
											<input type="hidden" name="query" value="<?php echo $query ?>"></input>
											<input type="hidden" name="sort_by" value="rating"></input>
										</form>
									</li>
									<li>	
										<form action= "search.php" method="GET">
											<button type="submit" class="btn btn-small btn-warning">Reviews</button>
											<input type="hidden" name="query" value="<?php echo $query ?>"></input>
											<input type="hidden" name="sort_by" value="reviews"></input>
										</form>
									</li>	
								</ul>
								<div style='clear: both; margin-bottom: 10px'></div>
				    		</div>
				<?php
				
				if ($sort_by == 'default') {
					$order_by = 'B.name';
				} else if ($sort_by == 'rating') {
					$order_by = 'avg_rating DESC, total_reviews DESC, B.name';
				} else if ($sort_by == 'reviews') {
					$order_by = 'total_reviews DESC, avg_rating DESC, B.name';
				} else if ($sort_by == 'name'){
					$order_by = 'B.name';
				}
				
				$sql = "SELECT ROWNUM, beer_id, beer_name, beer_description, abv, msrp, style_name, manufacturer_name, total_reviews, NVL(avg_rating, 0) FROM(
SELECT B.id AS beer_id, B.name AS beer_name, B.description AS beer_description, B.abv, B.msrp, S.description AS style_name, M.name AS manufacturer_name, COUNT (*) as total_reviews, NVL(AVG(rating),0) as avg_rating
FROM Beers B LEFT OUTER JOIN Reviews R on B.id = R.beerid, Beerstyles S, Manufacturers M, (SELECT * FROM BEERS B WHERE CATSEARCH(B.name, '(" . $query . ")', null) >0) TEMP
WHERE B.Manufacturerid = M.id AND B.beerstyleid = S.id AND B.id = TEMP.id
GROUP BY B.id, B.name, B.description, B.ABV, B.MSRP, S.description, M.name ORDER BY " . $order_by . ")";
				$stmt = oci_parse($conn, $sql);
				oci_execute($stmt, OCI_DEFAULT); 
				while($res = oci_fetch_row($stmt)) {
					echo "<a href='beer.php?id=" . urlencode($res[1]) . "'>";
					echo "<div id='search-entry' class='well clearfix'>";
					echo "<div class='span7' style='float: left; margin-left: 8px;'>";
					echo "<h1>" . $res[0] . ". " . $res[2] . "</h1>";
					echo "<p>" . $res[3] . "</p>";
					echo "<p> <span class='bold'>Brewed By:</span> " . $res[7] . "</p>";
					echo "<p> <span class='bold'>Style:</span> " . $res[6] . "</p>";
					echo "</div>";
					echo "<div class='span3' style='float: right; margin-right: 8px; text-align: right;'>";
					if ($res[9] == 0) {
						echo "<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>NR</h1>";
						echo "<p> No reviews</p>";
					} else if ($res[9] == 1) {
						echo "<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>" . number_format($res[9], 2) . " </h1>";
						echo "<p>" . $res[8] . " review</p>";
					} else {
						echo"<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>" . number_format($res[9], 2) . " </h1>";
						echo "<p>" . $res[8] . " reviews</p>";
					}
					echo "<p> <span class='bold'>MSRP:</span> $" . $res[5] . "</p>";
					echo "<p> <span class='bold'>ABV:</span> " . $res[4] . "%</p>";
					echo "</div>";
					echo "</div></a>";
				}
				?>
				
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