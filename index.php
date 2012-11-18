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
						<input class="search-box" type="text" name="query" placeholder="Search for beers or breweries" style="height: 36px; font-size: 16px; margin: 10px 0 16px 0; padding-left: 1%; padding-right: 1%;"></input>
						<input type="hidden" name="sort_by" value="default"></input>
					</form>
				</div>
			</div>
			
			<!-- page content -->
			<div class="row" style="margin-top: 8px;">
				<div class="span12">
					<div class="hero-unit">
						<h1>BrewCloud</h1>
						<p style="margin-left: 3px;">Beer knowledge, reviews, and availability gone social.</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span4">
					<h1 class="font-thin">Top Brews Overall</h2>
					<table class="table table-striped table-hover">
						<thead>
			            	<tr>
								<th>#</th>
								<th>Beer</th>
								<th>Rating</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						// Top Beers
						
						$sql = "SELECT B.id, B.name, AVG(R.rating) FROM beers B, reviews R WHERE B.id = R.beerid GROUP BY B.id, B.name ORDER BY AVG(R.rating) DESC";
						$stmt = oci_parse($conn, $sql);
						oci_execute($stmt, OCI_DEFAULT);
						
						$count = 0;
						while ($res = oci_fetch_row($stmt)) {
							if ($count < 10) {
								$count++;
								echo "<tr>";
								echo "<td>".$count."</td>";
								echo "<td><a href='beer.php?id=".$res[0]."'>".$res[1]."</a></td>";
								echo "<td>".number_format($res[2], 2)."</td>";
								echo "</tr>";
							}
							else {
								break;
							}
						}
						
						?>
						</tbody>
					</table>
				</div>
				<div class="span4">
					<h1 class="font-thin">Top American-Style Pale Ales</h2>
					<table class="table table-striped table-hover">
						<thead>
			            	<tr>
								<th>#</th>
								<th>Beer</th>
								<th>Rating</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						// American-Style Pale Ales
						
						$sql = "SELECT B.id, B.name, AVG(R.rating) AS avgrating FROM beers B, reviews R WHERE B.id = R.beerid AND B.beerstyleid = 26 GROUP BY B.id, B.name ORDER BY avgrating DESC";
						$stmt = oci_parse($conn, $sql);
						oci_execute($stmt, OCI_DEFAULT);
						
						$count = 0;
						while ($res = oci_fetch_row($stmt)) {
							if ($count < 10) {
								$count++;
								echo "<tr>";
								echo "<td>".$count."</td>";
								echo "<td><a href='beer.php?id=".$res[0]."'>".$res[1]."</a></td>";
								echo "<td>".number_format($res[2], 2)."</td>";
								echo "</tr>";
							}
							else {
								break;
							}
						}
						
						?>
						</tbody>
					</table>
				</div>
				<div class="span4">
					<h1 class="font-thin">Top Brews from New York</h2>
					<table class="table table-striped table-hover">
						<thead>
			            	<tr>
								<th>#</th>
								<th>Beer</th>
								<th>Rating</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						// Top Beers in New York
						
						$sql = "SELECT B.id, B.name, AVG(R.rating) AS avgrating FROM beers B, reviews R, manufacturers M, locations L WHERE B.id = R.beerid AND B.manufacturerid = M.id AND M.locationid = L.id AND L.city in ('New York', 'Brooklyn', 'Queens', 'Manhattan') GROUP BY B.id, B.name ORDER BY avgrating DESC";
						$stmt = oci_parse($conn, $sql);
						oci_execute($stmt, OCI_DEFAULT);
						
						$count = 0;
						while ($res = oci_fetch_row($stmt)) {
							if ($count < 10) {
								$count++;
								echo "<tr>";
								echo "<td>".$count."</td>";
								echo "<td><a href='beer.php?id=".$res[0]."'>".$res[1]."</a></td>";
								echo "<td>".number_format($res[2], 2)."</td>";
								echo "</tr>";
							}
							else {
								break;
							}
						}
			
						oci_close($conn);
						
						?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- end page content -->
			
		</div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>