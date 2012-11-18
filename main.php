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
			
			$sql = "SELECT B.id, B.name, AVG(R.rating) FROM beers B, reviews R WHERE ROWNUM <= 10 AND B.id = R.beerid GROUP BY B.id, B.name ORDER BY AVG(R.rating) DESC";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt, OCI_DEFAULT);
			
			$count = 0;
			while ($res = oci_fetch_row($stmt)) {
				++$count;
				echo "<tr>";
				echo "<td>".$count."</td>";
				echo "<td>".$res[1]."</td>";
				echo "<td>".number_format($res[2], 2)."</td>";
				echo "</tr>";
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
			
			$sql = "SELECT B.name, AVG(R.rating) AS avgrating FROM beers B, reviews R WHERE ROWNUM <= 10 AND B.id = R.beerid AND B.beerstyleid = 26 GROUP BY B.name ORDER BY avgrating DESC";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt, OCI_DEFAULT);
			
			$count = 0;
			while ($res = oci_fetch_row($stmt)) {
				++$count;
				echo "<tr>";
				echo "<td>".$count."</td>";
				echo "<td>".$res[0]."</td>";
				echo "<td>".number_format($res[1], 2)."</td>";
				echo "</tr>";
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
			
			$sql = "SELECT B.name, AVG(R.rating) AS avgrating FROM beers B, reviews R, manufacturers M, locations L WHERE ROWNUM <= 10 AND B.id = R.beerid AND B.manufacturerid = M.id AND M.locationid = L.id AND L.city in ('New York', 'Brooklyn', 'Queens', 'Manhattan') GROUP BY B.name ORDER BY avgrating DESC";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt, OCI_DEFAULT);
			
			$count = 0;
			while ($res = oci_fetch_row($stmt)) {
				++$count;
				echo "<tr>";
				echo "<td>".$count."</td>";
				echo "<td>".$res[0]."</td>";
				echo "<td>".number_format($res[1], 2)."</td>";
				echo "</tr>";
			}

			oci_close($conn);
			
			?>
			</tbody>
		</table>
	</div>
</div>
