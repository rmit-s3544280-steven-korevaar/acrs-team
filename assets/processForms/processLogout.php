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
include('./../../datalogging/Logger.php');
Logger::configure('./../../datalogging/xml/config.xml');
$logger = Logger::getLogger("main");

session_start();
$_SESSION = array();
session_destroy();
<<<<<<< HEAD
$logger->info("User logged out");
=======
	$logger->info("User logged out");
>>>>>>> 2473263718c74883bed01b010ee05a1e0182d8d0
header("location: ../../index.php");

exit(0);
?>