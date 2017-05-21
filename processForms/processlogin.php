<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process the user login.
 *
 * The script will check if the username AND password combination 
 * exists in the user table.
 *
 * If not it will redirect back to the login page with a error 
 * message.
 *
 * If it does, check whether if it a business owner or a customer, and
 * redirect appropriately.
 * 
 ********************************************************************/
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");
 
 /* Instantiate database */
include('./databaseClass.inc');
require_once('processes.php');
 
$username = $_POST['username'];
$password = $_POST['password'];
		
$results = processes::login($username, $password, $db);

if($results == 1)
{
	$logger->info("Owner logged in");
	header("location: ../../businessPage.php");	//If is a owner, send to owner management page
}
elseif($results == 2)
{
	$logger->info("Customer logged in");
	header("location: ../../customerPage.php");	//If is a customer, send to customer page
}
else
{
	$_SESSION['loginError'] = "! Incorrect username or password, Please try again.";
	$logger->info("User entered invalid login information.");
	header("location: ../../login.php");
}
 
exit(0);
?>