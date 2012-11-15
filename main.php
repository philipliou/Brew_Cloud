<div class="row">
	<div class="span4">
		<p>
		<?php
			ini_set('display_errors', 'On');
			$db = "w4111b.cs.columbia.edu:1521/adb";
			$conn = oci_connect("smp2183", "philsteve", $db);
			$stmt = oci_parse($conn, "select username from manufacturerusers");
			oci_execute($stmt, OCI_DEFAULT);
			while ($res = oci_fetch_row($stmt))
			{
				echo "User Name: ".$res[0]."<br />";
			}
			oci_close($conn);
		?>
		</p>
	</div>
	<div class="span4">
		<p>Cras quis mi turpis. Donec nisi leo, dapibus at tincidunt in, tincidunt at dui. Morbi consectetur suscipit suscipit. Nullam tincidunt risus nec nulla hendrerit tempor. Proin augue quam, mattis sit amet porttitor vel, hendrerit ut urna. Auris vitae tristique. In nibh elit, convallis eu pellentesque rutrum, tincidunt et ante. Phasellus quis nisi velit. In a dui ante.</p>
	</div>
	<div class="span4">
		<p>Morbi id turpis ac odio consectetur dignissim. Nullam eu urna quis dolor tincidunt molestie. Duis dignissim commodo lacus nec accumsan. Nam ut ipsum orci. Aenean molestie aliquet metus, a blandit mauris ornare nec. Etiam vitae enim vitae sem tincidunt fermentum.</p>
	</div>
</div>

<div style="background-color: #CCC; height: 1px; margin: 8px 0 8px 0;"></div>

<div class="row">
	<div class="span2">
		<p>Nulla et odio at augue bibendum aliquet sed quis ante. Vestibulum pellentesque varius libero, vitae mattis nulla tincidunt sed. Quisque lobortis neque sed turpis malesuada volutpat. Nulla vulputate, eros vel laoreet mattis,</p>
		<p>Nulla et odio at augue bibendum aliquet sed quis ante. Vestibulum pellentesque varius libero, vitae mattis nulla tincidunt sed. Quisque lobortis neque sed turpis malesuada volutpat. Nulla vulputate, eros vel laoreet mattis,</p>
	</div>
	<div class="span5">
		<p>Aliquam et enim in ligula sollicitudin ullamcorper eu eget metus. Aliquam tristique, enim in dapibus malesuada, eros metus luctus eros, et faucibus arcu lacus non nisi. Vestibulum vitae mi at felis euismod lacinia. Sed ut neque velit. Cras lobortis congue elit, viverra tempus turpis bibendum a. Mauris condimentum posuere scelerisque. Proin elementum justo et ante congue eget rhoncus dui ornare. Vestibulum commodo tellus vitae velit consectetur sodales. Mauris sit amet lacus nec leo iaculis interdum.</p>
		<p>Aliquam et enim in ligula sollicitudin ullamcorper eu eget metus. Aliquam tristique, enim in dapibus malesuada, eros metus luctus eros, et faucibus arcu lacus non nisi. Vestibulum vitae mi at felis euismod lacinia. Sed ut neque velit. Cras lobortis congue elit, viverra tempus turpis bibendum a. Mauris condimentum posuere scelerisque. Proin elementum justo et ante congue eget rhoncus dui ornare. Vestibulum commodo tellus vitae velit consectetur sodales. Mauris sit amet lacus nec leo iaculis interdum.</p>
	</div>
	<div class="span5">
		<p>Aliquam et enim in ligula sollicitudin ullamcorper eu eget metus. Aliquam tristique, enim in dapibus malesuada, eros metus luctus eros, et faucibus arcu lacus non nisi. Vestibulum vitae mi at felis euismod lacinia. Sed ut neque velit. Cras lobortis congue elit, viverra tempus turpis bibendum a. Mauris condimentum posuere scelerisque. Proin elementum justo et ante congue eget rhoncus dui ornare. Vestibulum commodo tellus vitae velit consectetur sodales. Mauris sit amet lacus nec leo iaculis interdum.</p>
		<p>Aliquam et enim in ligula sollicitudin ullamcorper eu eget metus. Aliquam tristique, enim in dapibus malesuada, eros metus luctus eros, et faucibus arcu lacus non nisi. Vestibulum vitae mi at felis euismod lacinia. Sed ut neque velit. Cras lobortis congue elit, viverra tempus turpis bibendum a. Mauris condimentum posuere scelerisque. Proin elementum justo et ante congue eget rhoncus dui ornare. Vestibulum commodo tellus vitae velit consectetur sodales. Mauris sit amet lacus nec leo iaculis interdum.</p>
	</div>
</div>
