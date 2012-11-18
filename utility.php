<!-- Utility functions -->

<?php
	function is_logged_in()
	{
		if (isset($_SESSION['username'])) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	function log_out()
	{
		session_destroy();
	}
	
	function getPageURL()
	{
		$pageURL = "";
		$pageURL .= $_SERVER["REQUEST_URI"];
 		return $pageURL;
	}
?>
