<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Steven Korevaar	s3544280
 *
 * PHP script used to process employee add working period.
 *
 * The script will check if all data fields are filled in, and whether
 * the date time is valid.
 * If not return back to the Add shift page with error message.
 *
 * If true it will check whether the date times are valid and insert 
 * the work period into the table and return a success message.
 * 
 ********************************************************************/

/* Adding logging config path */
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");

/* Instantiate database */
include('./databaseClass.inc');

if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) && !empty($_POST['employeeID']))
{

	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$employeeID = $_POST['employeeID'];
	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$startDateTime = dateFormatter($date, $startTime);
	$endDateTime = dateFormatter($date, $endTime);
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if($startDateTime < $endDateTime) {
		$result = $db->insert("insert into workPeriod values(null,'$startDateTime','$endDateTime','$employeeID');");
		if($result != false){
			$_SESSION['shiftAdded'] = "Successfully added working time.";
			$logger->info("Working time added Successfully");
			header("location: ../../businessPageEmployeeAddShift.php");
		}
		else{
			$_SESSION['shiftError'] = "Unable to add shift.";
			$logger->error("Error occured while trying to add shift");
			header("location: ../../businessPageEmployeeAddShift.php");
		}
	}
	else {
		$_SESSION['shiftError'] = "The end time must be after the start time.";
		$logger->error("Error occured while trying to add add shift, the end time must be after the start time");
		header("location: ../../businessPageEmployeeAddShift.php");
	}
	
}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
	$logger->error("Error occured while trying to add shift, all fields have to be filled");
	header("location: ../../businessPageEmployeeAddShift.php");
} 

function dateFormatter($date, $time)
{
	$datePieces = explode("/", $date);
	$combineDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $time:00";
	return date("Y-m-d H:i:s", strtotime($combineDateTime));
}

?>