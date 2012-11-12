<?php
	session_start();
	
	$pageName = "index";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link href="css/bootstrap.css" rel="stylesheet" />
	<link href="css/bootstrap-responsive.css" rel="stylesheet" />
	<link href="http://www.stevepappas.net/css/style.css?a1" rel="stylesheet" />
</head>
<body>
	<div class="wrapper">
		<?php include("header.php"); ?>
	
		<div class="container">
			<div style="height: 52px;"></div>
			<div class="row">
				<div class="span12" style="text-align: center">
					<p>Search box</p>
				</div>
			</div>
			<div class="row">
		  		<div class="span2">
		  			Column 1
		  		</div>
		  		<div class="span5">Column 2</div>
		  		<div class="span5">Column 3</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		
		<div class="push"></div>
	
	</div>

	<?php include("footer.php"); ?>
</body>
</html>