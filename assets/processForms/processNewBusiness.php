<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process adding new Business.
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

if(checkExistingFields() == true){
	
	$password = $_POST['password'];
	$checkpassword = $_POST['checkpassword'];
	
	$openingTime = $_POST['openingTime'];
	$closingTime = $_POST['closingTime'];
	
	$name = $_POST['name'];
	$ownerName = $_POST['ownerName'];
	$address = $_POST['address'];
	$phoneNo = $_POST['phoneNo'];
	$ABN = $_POST['ABN'];
	$username = $_POST['username'];
	
	processes::newBusiness($password, $checkpassword, $openingTime, $closingTime, $name, $ownerName, $address, $phoneNo, $ABN, $username, $db, $logger);
}
else{
	$_SESSION['returnData'] = array($_POST['name'],$_POST['ownerName'],$_POST['address'],$_POST['phoneNo'],
	$_POST['openingTime'],$_POST['closingTime'],$_POST['ABN'],$_POST['username']);
	$_SESSION['registerError'] = "! All fields are required.";
	$logger->error("Error occured while user was trying to register, all fields need to be filled");
	header("location: ../../createANewBusiness.php");
}

// Check whether all fields are not empty.
function checkExistingFields(){
	$checkPOSTData = array('name','ownerName','address','phoneNo','openingTime','closingTime','ABN','username','password','checkpassword');
	$checkFILESData = array('image');
	foreach($checkPOSTData as $data){
		if(empty($_POST[$data])){
			return false;
		}
	}
	foreach($checkFILESData as $data){
		if(empty($_FILES[$data])){
			return false;
		}
	}
	return true;
}

?>