<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process customer booking.
 *
 * The script will check if all data fields are filled in.
 * If not return back to the booking page with error message.
 *
 * If true it will check whether the date times are valid and insert 
 * booking into table.
 * 
 ********************************************************************/

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");


/* Instantiate database */
include('./databaseClass.inc');
require_once('processes.php');

if (checkExistingFields() == true)
{
	
	$username = $_SESSION['username'];
	$abn = $_SESSION['abn'];
	
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$otherDetails = $_POST['otherDetails'];
	$employee = $_POST['employeeID'];
	$activities = $_POST['selectedActivities'];
	
	$locF = "location: ../../customerBooking.php";
	$locS = "location: ../../customerPage.php";

	/* Rearrange date time into format which PHP and MySQL can manipulate */
	processes::booking($username, $abn, $date, $startTime, $endTime, $employee, $otherDetails, $activities, $db, $logger, $locS, $locF);
}
else
{
	$_SESSION['bookingError'] = "Please enter in all fields.";

	$logger->error("Booking was not successful, all fields have to be filled");
	header("location: ../../customerBooking.php");
} 

// Check whether all fields are not empty.
function checkExistingFields(){
	$checkSessionData = array('username','abn');
	$checkPOSTData = array('selectedActivities','date','startTime','endTime','employeeID');
	foreach($checkSessionData as $data){
		if(empty($_SESSION[$data])){
			return false;
		}
	}
	foreach($checkPOSTData as $data){
		if(empty($_POST[$data])){
			return false;
		}
	}
	return true;
}

?>