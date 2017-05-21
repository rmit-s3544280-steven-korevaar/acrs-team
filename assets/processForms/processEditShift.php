<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Steven Korevaar	s3544280
 *
 * PHP script used to process employee edit working period.
 *
 * The script will check if all data fields are filled in, and whether
 * the date time is valid.
 * If not return back to the Edit shift page with error message.
 *
 * If true it will check whether the date times are valid and 
 * edit or delete the work period in the table 
 * and return a message.
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
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$workPeriodID = $_POST['workperiodID'];
	$employeeID = $_POST['employeeID'];
	$action = $_POST['action'];
	
	$results = processes::editShift($date, $startTime, $endTime, $workPeriodID, $employeeID, $action, $db);
	echo $results;

	if($results == 1)
	{
		$_SESSION['shiftAdded'] = "Successfully Edited working time.";
		$logger->info("Working time has been changed successfully");
		header("location: ../../businessPageEmployeeEditShift.php");
	}
	elseif($results == 2)
	{
		$_SESSION['shiftAdded'] = "Successfully Deleted working time.";
		$logger->info("Working time has been deleted successfully");
		header("location: ../../businessPageEmployeeEditShift.php");
	}
	elseif($results == -1)
	{
		$_SESSION['shiftError'] = "Work Period cannot overlap.";
		$logger->error("Error occured while changing the shift, work period cannot overlap");
		header("location: ../../businessPageEmployeeEditShift.php");
	}
	elseif($results == -2)
	{
		$_SESSION['shiftError'] = "The end time must be after the start time.";
		$logger->error("Error occured while changing the shift, the end time must be after the start time");
		header("location: ../../businessPageEmployeeEditShift.php");
	}
	else
	{
		$_SESSION['shiftError'] = "An unknown error has occured.";
		$logger->error("Error occured while changing the shift");
		header("location: ../../businessPageEmployeeEditShift.php");
	}

}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
	$logger->error("Error occured while changing the shift, all fields have to be filled");
	header("location: ../../businessPageEmployeeEditShift.php");
}
// Check whether all fields are not empty.
function checkExistingFields(){
	$checkPOSTData = array('date','startTime','endTime','workperiodID','employeeID','action');
	foreach($checkPOSTData as $data){
		if(empty($_POST[$data])){
			return false;
		}
	}
	return true;
}

?>