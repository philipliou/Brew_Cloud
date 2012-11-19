<?php
	session_start();
	
	require_once("config.php");
	require_once("utility.php");
	
	$username = strtolower($_REQUEST['username']);
	$password = $_REQUEST['password'];
	$username = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
	
	$stmt1 = oci_parse($conn, "select username, password, email, firstname, lastname, id from adminusers where username = '".$username."'");
	$stmt2 = oci_parse($conn, "select username, password, email, firstname, lastname, id from resellerusers where username = '".$username."'");
	$stmt3 = oci_parse($conn, "select username, password, email, firstname, lastname, id from manufacturerusers where username = '".$username."'");
	$stmt4 = oci_parse($conn, "select username, password, email, firstname, lastname, id from endusers where username = '".$username."'");
	
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
			$_SESSION['email'] = $res1[2];
			$_SESSION['name'] = $res1[3]." ".$res1[4];
			$_SESSION['id'] = $res1[5];
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res2) {
		if ($res2[1] == $password) {
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $res2[2];
			$_SESSION['name'] = $res2[3]." ".$res2[4];
			$_SESSION['id'] = $res2[5];
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res3) {
		if ($res3[1] == $password) {
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $res3[2];
			$_SESSION['name'] = $res3[3]." ".$res3[4];
			$_SESSION['id'] = $res3[5];
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else if ($res4) {
		if ($res4[1] == $password) {
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $res4[2];
			$_SESSION['name'] = $res4[3]." ".$res4[4];
			$_SESSION['id'] = $res4[5];
		}
		else {
			$_SESSION['error'] = "PASSWORD INCORRECT";
		}
	}
	else {
		$_SESSION['error'] = "USERNAME NOT FOUND";
	}
	
	oci_close($conn);
	header('location: http://w4111a.cs.columbia.edu/~smp2183/brewcloud/ps1337.php');
?>