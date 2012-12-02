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
	
	if (isset($_GET["rating"])) {
		$minRating = $_GET["rating"];
	}
	else {
		$minRating = 1;
	}
	
	if (isset($_GET["reviews"])) {
		$minReviews = $_GET["reviews"];
	}
	else {
		$minReviews = 0;
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
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" value="<?php echo $query; ?>" style="height: 36px; font-size: 16px; margin: 10px 0 16px 0; padding-left: 10px; padding-right: 10px;"></input>
						<input type="hidden" name="sort_by" value="default"></input>
						<input type="hidden" name="rating" value="0"></input>
						<input type="hidden" name="reviews" value="0"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<?php if (isset($_GET["query"]) && $query) { ?>
			<div class="row">
				<div id="search-filters" class="span2">
					<div class="img-polaroid" style='margin-bottom: 10px'>
						<div class="inner-polaroid">
							<h2 class="bold">Filters</h2>
							<form action= "search.php" method="GET">
								<input type="hidden" name="query" value="<?php echo $query ?>"></input>
								<input type="hidden" name="sort_by" value="<?php echo $sort_by ?>"></input>
								<p>Minimum Rating</p>
								<select name="rating" style="width: 120px;">
									<option value="5" <?php if ($minRating == 5) { echo 'selected="selected"'; } ?> >5 stars</option>
									<option value="4" <?php if ($minRating == 4) { echo 'selected="selected"'; } ?> >4 stars</option>
									<option value="3" <?php if ($minRating == 3) { echo 'selected="selected"'; } ?> >3 stars</option>
									<option value="2" <?php if ($minRating == 2) { echo 'selected="selected"'; } ?> >2 stars</option>
									<option value="1" <?php if ($minRating == 1) { echo 'selected="selected"'; } ?> >1 star</option>
									<option value="0" <?php if ($minRating == 0) { echo 'selected="selected"'; } ?> >No Rating</option>
								</select>
								<p>Minimum # Reviews</p>
								<select name="reviews" style="width: 120px;">
									<option value="10" <?php if ($minReviews == 10) { echo 'selected="selected"'; } ?> >10</option>
									<option value="5" <?php if ($minReviews == 5) { echo 'selected="selected"'; } ?> >5</option>
									<option value="3" <?php if ($minReviews == 3) { echo 'selected="selected"'; } ?> >3</option>
									<option value="1" <?php if ($minReviews == 1) { echo 'selected="selected"'; } ?> >1</option>
									<option value="0" <?php if ($minReviews == 0) { echo 'selected="selected"'; } ?> >0</option>
								</select>
								<button type="submit" class="btn btn-small btn-warning" style="margin-top: 4px; margin-bottom: 4px;">Filter</button>
							</form>
						</div>
					</div>
				</div>
				<div class="span10">
					<h2 style="margin-bottom: 20px;">
						<span class='bold'>
							<?php 	
							//$sql = "SELECT COUNT(*) FROM Beers B WHERE CATSEARCH(B.NAME, '(" . $query . ")', NULL) >0";
							$sql = "SELECT COUNT(*) FROM(SELECT B.id AS beer_id, B.name AS beer_name, B.description AS beer_description, B.abv, B.msrp, S.description AS style_name, M.name AS manufacturer_name, case when NVL(AVG(rating),0) = 0 then 0 else COUNT(*) end as total_reviews, NVL(AVG(rating),0) as avg_rating FROM Beers B LEFT OUTER JOIN Reviews R on B.id = R.beerid, Beerstyles S, Manufacturers M, (SELECT * FROM BEERS B WHERE CATSEARCH(B.name, '(" . $query . ")', null) > 0) TEMP WHERE B.Manufacturerid = M.id AND B.beerstyleid = S.id AND B.id = TEMP.id GROUP BY B.id, B.name, B.description, B.ABV, B.MSRP, S.description, M.name" . ") WHERE avg_rating >=" . $minRating . "AND total_reviews >=" .$minReviews;							
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
											<input type="hidden" name="rating" value="<?php echo $minRating ?>"></input>
											<input type="hidden" name="reviews" value="<?php echo $minReviews ?>"></input>
										</form>
									</li>
									<li>
										<form action= "search.php" method="GET">
											<button type="submit" class="btn btn-small btn-warning">Rating</button>
											<input type="hidden" name="query" value="<?php echo $query ?>"></input>
											<input type="hidden" name="sort_by" value="rating"></input>
											<input type="hidden" name="rating" value="<?php echo $minRating ?>"></input>
											<input type="hidden" name="reviews" value="<?php echo $minReviews ?>"></input>
										</form>
									</li>
									<li>	
										<form action= "search.php" method="GET">
											<button type="submit" class="btn btn-small btn-warning">Reviews</button>
											<input type="hidden" name="query" value="<?php echo $query ?>"></input>
											<input type="hidden" name="sort_by" value="reviews"></input>
											<input type="hidden" name="rating" value="<?php echo $minRating ?>"></input>
											<input type="hidden" name="reviews" value="<?php echo $minReviews ?>"></input>
										</form>
									</li>	
								</ul>
								<div style='clear: both;'></div>
				    		</div>
				    		<div style="margin-top: 10px;">
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
				
				/*$sql = "SELECT ROWNUM, beer_id, beer_name, beer_description, abv, msrp, style_name, manufacturer_name, total_reviews, NVL(avg_rating, 0) FROM(
SELECT B.id AS beer_id, B.name AS beer_name, B.description AS beer_description, B.abv, B.msrp, S.description AS style_name, M.name AS manufacturer_name, COUNT (*) as total_reviews, NVL(AVG(rating),0) as avg_rating
FROM Beers B LEFT OUTER JOIN Reviews R on B.id = R.beerid, Beerstyles S, Manufacturers M, (SELECT * FROM BEERS B WHERE CATSEARCH(B.name, '(" . $query . ")', null) > 0) TEMP
WHERE B.Manufacturerid = M.id AND B.beerstyleid = S.id AND B.id = TEMP.id
GROUP BY B.id, B.name, B.description, B.ABV, B.MSRP, S.description, M.name ORDER BY " . $order_by . ")"; */
				$sql = "SELECT beer_id, beer_name, beer_description, abv, msrp, style_name, manufacturer_name, total_reviews, NVL(avg_rating, 0) FROM(
SELECT B.id AS beer_id, B.name AS beer_name, B.description AS beer_description, B.abv, B.msrp, S.description AS style_name, M.name AS manufacturer_name, case when NVL(AVG(rating),0) = 0 then 0 else COUNT(*) end as total_reviews, NVL(AVG(rating),0) as avg_rating
FROM Beers B LEFT OUTER JOIN Reviews R on B.id = R.beerid, Beerstyles S, Manufacturers M, (SELECT * FROM BEERS B WHERE CATSEARCH(B.name, '(" . $query . ")', null) > 0) TEMP
WHERE B.Manufacturerid = M.id AND B.beerstyleid = S.id AND B.id = TEMP.id GROUP BY B.id, B.name, B.description, B.ABV, B.MSRP, S.description, M.name ORDER BY " . $order_by . ") WHERE avg_rating >=" . $minRating . "AND total_reviews >=" .$minReviews;
				$stmt = oci_parse($conn, $sql);
				oci_execute($stmt, OCI_DEFAULT); 
				while($res = oci_fetch_row($stmt)) {
					echo "<a href='beer.php?id=" . urlencode($res[0]) . "'>";
					echo "<div id='search-entry' class='well clearfix'>";
					echo "<div class='span6' style='float: left; margin-left: 8px;'>";
					echo "<h1>" . $res[1] . "</h1>";
					echo "<p>" . $res[2] . "</p>";
					echo "<p> <span class='bold'>Brewed By:</span> " . $res[6] . "</p>";
					echo "<p> <span class='bold'>Style:</span> " . $res[5] . "</p>";
					echo "</div>";
					echo "<div class='span2' style='float: right; margin-right: 8px; text-align: right;'>";
					if ($res[8] == 0) {
						echo "<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>NR</h1>";
						echo "<p> No reviews</p>";
					} else if ($res[8] == 1) {
						echo "<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>" . number_format($res[8], 2) . " </h1>";
						echo "<p>" . $res[7] . " review</p>";
					} else {
						echo"<h1 style='font-size: 48px; margin-top: 12px; margin-bottom: 12px;'>" . number_format($res[8], 2) . " </h1>";
						echo "<p>" . $res[7] . " reviews</p>";
					}
					echo "<p> <span class='bold'>MSRP:</span> $" . $res[4] . "</p>";
					echo "<p> <span class='bold'>ABV:</span> " . $res[3] . "%</p>";
					echo "</div>";
					echo "</div></a>";
				}
				?>
				
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