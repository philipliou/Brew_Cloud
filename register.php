<?php
	session_start();
	
	require_once("config.php");
	require_once("utility.php");
	
	$check = TRUE;
	$badUsername = FALSE;
	$badEmail = FALSE;
	
	$username = strtolower($_REQUEST['username']);
	$password = $_REQUEST['password'];
	$email = strtolower($_REQUEST['email']);
	$firstName = $_REQUEST['firstname'];
	$lastName = $_REQUEST['lastname'];
	
	$username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
	$email = filter_var($email, FILTER_SANITIZE_SPECIAL_CHARS);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$firstName = filter_var($firstName, FILTER_SANITIZE_SPECIAL_CHARS);
	$lastName = filter_var($lastName, FILTER_SANITIZE_SPECIAL_CHARS);
	
	if ($username == "" || $password == "" || $email == "") {
		$_SESSION['error'] = "PLEASE FILL IN ALL REQUIRED FIELDS";
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION['error'] = "INVALID EMAIL ADDRESS";
	}
	else {
	
	$stmt1 = oci_parse($conn, "select username, email from adminusers where username = '".$username."' or email = '".$email."'");
	$stmt2 = oci_parse($conn, "select username, email from resellerusers where username = '".$username."' or email = '".$email."'");
	$stmt3 = oci_parse($conn, "select username, email from manufacturerusers where username = '".$username."' or email = '".$email."'");
	$stmt4 = oci_parse($conn, "select username, email from endusers where username = '".$username."' or email = '".$email."'");
	
	oci_execute($stmt1, OCI_DEFAULT);
	$res1 = oci_fetch_row($stmt1);
	while ($res1)
	{
		if ($username == $res1[0]) {
			$badUsername = TRUE;
		}
		else if ($email == $res1[1]) {
			$badEmail = TRUE;
		}
		$check = FALSE;
		$res1 = oci_fetch_row($stmt1);
	}
	oci_execute($stmt2, OCI_DEFAULT);
	while ($res2 = oci_fetch_row($stmt2))
	{
		if ($username == $res2[0]) {
			$badUsername = TRUE;
		}
		else if ($email == $res2[1]) {
			$badEmail = TRUE;
		}
		$check = FALSE;
		$res2 = oci_fetch_row($stmt1);
	}
	oci_execute($stmt3, OCI_DEFAULT);
	while ($res3 = oci_fetch_row($stmt3))
	{
		if ($username == $res3[0]) {
			$badUsername = TRUE;
		}
		else if ($email == $res3[1]) {
			$badEmail = TRUE;
		}
		$check = FALSE;
		$res3 = oci_fetch_row($stmt1);
	}
	oci_execute($stmt4, OCI_DEFAULT);
	while ($res4 = oci_fetch_row($stmt4))
	{
		if ($username == $res4[0]) {
			$badUsername = TRUE;
		}
		else if ($email == $res4[1]) {
			$badEmail = TRUE;
		}
		$check = FALSE;
		$res4 = oci_fetch_row($stmt1);
	}
	
	if ($check) {
		// Do insert and log in
		$sql = "insert into endusers values (endusers_seq.nextval, '".$username."', '".$firstName."', '".$lastName."', '".$email."', NULL, 0, '".$password."')";
		$stmt = oci_parse($conn, $sql);
		oci_execute($stmt, OCI_DEFAULT);
		$err = oci_error($stmt);
		if ($err) {
			oci_rollback($conn);
			$_SESSION['error'] = $err['message'];
		}
		else {
			oci_commit($conn);
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $email;
			$_SESSION['name'] = $firstName." ".$lastName;
			
			$stmtUser = oci_parse($conn, "select id from endusers where username = '".$username."'");
			oci_execute($stmtUser, OCI_DEFAULT);
			$resUser = oci_fetch_row($stmtUser);
			if ($resUser) {
				$_SESSION['id'] = $resUser[0];
			}
		}
	}
	else {
		if ($badUsername) {
			$_SESSION['error'] = "USERNAME ALREADY EXISTS";
		}
		else if ($badEmail) {
			$_SESSION['error'] = "EMAIL ALREADY EXISTS";
		}
		else {
			$_SESSION['error'] = "USERNAME OR EMAIL ALREADY EXISTS";
		}
	}
	
	oci_close($conn);
	}
	
	header('location: http://w4111a.cs.columbia.edu/~smp2183/brewcloud/ps1337.php');
?>