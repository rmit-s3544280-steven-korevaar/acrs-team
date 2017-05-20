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
 
$username = $_POST['username'];
$password = $_POST['password'];
//Check if valid user.
$results = $db->select("select * from user where username='$username' and password=SHA('$password');");
if(mysqli_num_rows($results) > 0){
	//Store username in the global array under the username variable, for future use.
	$_SESSION['username'] = "$username";
	//Check to see if it is a customer or a owner
	$checkResult = $db->select("select * from userbusiness where username like '$username' AND ABN = '{$_SESSION['abn']}';");
	if(mysqli_num_rows($checkResult) > 0){	//If a result is found, check to see if the user is a owner.
		$logger->info("Owner logged in");
		header("location: ../../businessPage.php");	//If is a owner, send to owner management page
	}
	
	else{	//If nothing is found in the userbusiness table, the user is not a owner, but is just a regular customer
		$logger->info("Customer logged in");
		header("location: ../../customerPage.php");	//If is a customer, send to customer page
	}
}
else{
	//If incorrect username or password, send back to index.php with a error message.
	$_SESSION['loginError'] = "! Incorrect username or password, Please try again.";
	$logger->info("User entered invalid login information.");
	header("location: ../../login.php");
}
exit(0);
?>