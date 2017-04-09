<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process the logout hyperlink on the customer and
 * business owner navigation bar.
 *
 * The script will start a session, set session global array to empty,
 * and clear all stored cookie data in case.
 * 
 * And then redirect back to login page.
 ********************************************************************/

session_start();
$_SESSION = array();
session_destroy();
header("location: ../../index.php");
exit(0);
?>