<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Asli Yoruk			s3503519
 *
 * PHP script used to process add new employee into the system.
 *
 * The script will check if all data fields are filled in.
 * If not return back to the Add new employee with error message.
 *
 * If true it will add the new employee into the database.
 * The query will return a message if the employeeID is not unique,
 * and return a error message.
 * 
 ********************************************************************/

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");

/* Instantiate database */
include('./databaseClass.inc');
require_once("processes.php");

/* ADD SERVICES PART */
/*If all data exists, continue with the adding employee process*/
if( checkExistingFields() == true ){
	$businessID = $_SESSION['abn'];
	$serviceName = $_POST['serviceName'];
	$durationM = $_POST['durationM'];
	
	$results = processes::addServices($durationM, $businessID, $serviceName, $db);

	if($results == 1)
	{
		//If successful add, refresh the page businessPageEmployeeEditServices.php with success message.
		$_SESSION['returnSuccess'] = "Successfully added new Service.";
		$logger->info("Owner successfully added a new service");
		header("location: ./../../businessPageEmployeeAddServices.php");
	}
	else
	{
		$_SESSION['returnError'] = "Duration needs to be within 1 and 60 mins.";
		$logger->error("Error occured while owner trying to add a new service, Invalid duration. ");
		header("location: ./../../businessPageEmployeeAddServices.php");
	}
	
}
else{
	$_SESSION['returnError'] = "Please enter data in all fields.";
	$logger->error("Error occured while owner trying to add a new service, all fields need to be filled ");
	header("location: ./../../businessPageEmployeeAddServices.php");
}

function checkExistingFields(){
	$checkPOSTData = array('serviceName','durationM');
	$checkSessionData = array('abn');
	foreach($checkPOSTData as $data){
		if(!isset($_POST[$data])){
			return false;
		}
	}
	foreach($checkSessionData as $data){
		if(!isset($_SESSION[$data])){
			return false;
		}
	}
	return true;
}

?>