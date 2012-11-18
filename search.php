<?php
	session_start();
	
	$pageName = "index";
	require_once("config.php");
	require_once("utility.php");
	
	if (isset($_GET["query"])) {
		$query = strtolower($_GET["query"]);
		$query = filter_var($query, FILTER_SANITIZE_SPECIAL_CHARS);
	}
	else {
		$query = "";
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
					<div> Sort by Beer Name Number of Reviews </div>
				<?php 
				$sql = "SELECT ROWNUM, beer_id, beer_name, beer_description, abv, msrp, style_name, manufacturer_name, total_reviews, avg_rating FROM(
SELECT B.id AS beer_id, B.name AS beer_name, B.description AS beer_description, B.abv, B.msrp, S.name AS style_name, M.name AS manufacturer_name, COUNT (*) as total_reviews, AVG(rating) as avg_rating
FROM Beers B LEFT OUTER JOIN Reviews R on B.id = R.beerid, Beerstyles S, Manufacturers M, (SELECT * FROM BEERS B WHERE CATSEARCH(B.name, '(" . $query . ")', null) >0) TEMP
WHERE B.Manufacturerid = M.id AND B.beerstyleid = S.id AND B.id = TEMP.id
GROUP BY B.id, B.name, B.description, B.ABV, B.MSRP, S.name, M.name ORDER BY B.name)";
				$stmt = oci_parse($conn, $sql);
				oci_execute($stmt, OCI_DEFAULT); 
				while($res = oci_fetch_row($stmt)) {
					echo "<a href='beer.php?id=" . urlencode($res[1]) . "'>";
					echo "<div class='well well-large clearfix'><div class='span7'>";
					echo "<h2><span class='bold'>" . $res[0] . ". " . $res[2] . "</span></h2>";
					echo "<p>" . $res[3] . "</p>";
					echo "<p> Manufacturer: " . $res[7] . "</p>";
					echo "<p> Beer Style: " . $res[6] . "</p>";
					echo "<p> ABV: " . $res[4] . "%</p>";
					echo "<p> MSRP: $" . $res[5] . "</p></div>";
					echo "<div class='span2 pull-right'>";
						echo"<h1>" . $res[9] . "</h1>";
						echo "<p>" . $res[8] . " reviews</p>";
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