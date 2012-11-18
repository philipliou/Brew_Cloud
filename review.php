<?php

if (isset($_REQUEST['rating'])) {
	$rating = $_REQUEST['rating'];
	$review = $_REQUEST['review'];
	$userid = $_SESSION['id'];
	$beerid = $id;
	
	if ($review != "") {
	
		$review = filter_var($review, FILTER_SANITIZE_SPECIAL_CHARS);
		
		$date = new DateTime();
		$dateInsert = $date->format('Y/m/d:H:i:s');
		
		$sql = "insert into reviews values (".$userid.", ".$beerid.", ".$rating.", '".$review."', 0, to_date('".$dateInsert."', 'yyyy/mm/dd:hh24:mi:ss'))";
		$stmt = oci_parse($conn, $sql);
		oci_execute($stmt, OCI_DEFAULT);
		$err = oci_error($stmt);
		if ($err) {
			oci_rollback($conn);
			if ($review == "") {
				$_SESSION['error'] = "Both rating and description are required";
			}
			else {
				$_SESSION['error'] = "You've already reviewed this beer";
			}
		}
		else {
			oci_commit($conn);
		}
	}
	else {
		$blank = "Both rating and description are required";
	}
}

?>