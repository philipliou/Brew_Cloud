<?php
	session_start();
	session_unset();
	session_destroy();
	
	header('location: http://w4111a.cs.columbia.edu/~smp2183/');
?>
