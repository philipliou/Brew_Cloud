<?php
	session_start();
	
	require_once("config.php");
	require_once("utility.php");
	
	$username = strtolower($_REQUEST['username']);
	$password = $_REQUEST['password'];
	
	$stmt1 = oci_parse($conn, "select username, password from adminusers where username = '".$username."'");
	$stmt2 = oci_parse($conn, "select username, password from resellerusers where username = '".$username."'");
	$stmt3 = oci_parse($conn, "select username, password from manufacturerusers where username = '".$username."'");
	$stmt4 = oci_parse($conn, "select username, password from endusers where username = '".$username."'");
	
	oci_execute($stmt1, OCI_DEFAULT);
	$res1 = oci_fetch_row($stmt1);
	oci_execute($stmt2, OCI_DEFAULT);
	$res2 = oci_fetch_row($stmt2);
	oci_execute($stmt3, OCI_DEFAULT);
	$res3 = oci_fetch_row($stmt3);
	oci_execute($stmt4, OCI_DEFAULT);
	$res4 = oci_fetch_row($stmt4);
	
	if ($res1) {
		if ($res1[1] == $password) {
			$_SESSION['username'] = $username;
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res2) {
		if ($res2[1] == $password) {
			$_SESSION['username'] = $username;
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res3) {
		if ($res3[1] == $password) {
			$_SESSION['username'] = $username;
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res4) {
		if ($res4[1] == $password) {
			$_SESSION['username'] = $username;
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else {
		$_SESSION['error'] = "USERNAME NOT FOUND";
	}
	
	header('location: http://w4111a.cs.columbia.edu/~smp2183/');
?>