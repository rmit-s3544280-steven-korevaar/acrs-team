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

//adding datalogging config 
include('./../../datalogging/Logger.php');
Logger::configure('./../../datalogging/xml/config.xml');
$logger = Logger::getLogger("main");

session_start();
$_SESSION = array();
session_destroy();
	$logger->info("User logged out");
header("location: ../../index.php");

exit(0);
?>