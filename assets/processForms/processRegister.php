<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process customer registration after Register
 * button is clicked on.
 *
 * The script will validate whether the input data is valid for MySQL
 * query/insertion, insert into the database and return a success
 * message. 
 * 
 * If it is not valid it will return a error message to the user.
 ********************************************************************/

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");

/* Instantiate database */
include('./databaseClass.inc');
require_once('processes.php');

/*Check if input data exists and Initialise variables to call easier*/
$checkForData = array('username','password','fullname','address','phone');
$checkFlag = true;
foreach($checkForData as $data){
	if(empty($_POST[$data])){
		$checkFlag = false;
	}
}
/*If all data exists, continue with the register process*/
if($checkFlag == true){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$checkpassword = $_POST['checkpassword'];
	$fullname = $_POST['fullname'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	
	if ( helpers::checkPassword($password,$checkpassword) == false){
		$_SESSION['registerError'] = "! Passwords do not match.";
		$logger->error("Error occured while user was trying to register, Passwords do not match");
		header("location: ../../login.php");
		exit(0);
	}
	$results = processes::register($username, $fullname, $address, $phone, $password, $db, $logger);
	
	if($results == 1)
	{
		$_SESSION['registerSuccess'] = "Register successful, Please login.";
		$logger->info("User successfully registered");
		header("location: ../../login.php");
	}
	else
	{
		$_SESSION['registerError'] = "! That username is unavailable, Please try another.";
		$logger->error("Error occured while user was trying to register, username is unavailable");
		header("location: ../../login.php");
	}
}
else{
	$_SESSION['returnData'] = array($_POST['username'],$_POST['password'],$_POST['fullname'],$_POST['address'],$_POST['phone']);
	$_SESSION['registerError'] = "! All fields are required.";
	$logger->error("Error occured while user was trying to register, all fields need to be filled");
	header("location: ../../login.php");
}

exit(0);
?>