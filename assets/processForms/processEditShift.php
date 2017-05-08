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

if (checkExistingFields() == true)
{
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$workperiodID = $_POST['workperiodID'];
	$employeeID = $_POST['employeeID'];
	$action = $_POST['action'];
	
	$startDateTime = dateFormatter($date, $startTime);
	$endDateTime = dateFormatter($date, $endTime);
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if($action == "Edit Shift"){
		if( timeCheck($startDateTime,$endDateTime) == true ){
			if( checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID) == true )
			{
				$result = $db->update("UPDATE workPeriod SET startDateTime='$startDateTime', 
				endDateTime='$endDateTime' WHERE workperiodID=$workperiodID;");
				$_SESSION['shiftAdded'] = "Successfully Edited working time.";
				$logger->info("Working time has been changed successfully");
				header("location: ../../businessPageEmployeeEditShift.php");
			}
			else{
				$_SESSION['shiftError'] = "Work Period cannot overlap.";
				$logger->error("Error occured while changing the shift, work period cannot overlap");
				header("location: ../../businessPageEmployeeEditShift.php");
			}
		}
		else{
			$_SESSION['shiftError'] = "The end time must be after the start time.";
			$logger->error("Error occured while changing the shift, the end time must be after the start time");
			header("location: ../../businessPageEmployeeEditShift.php");
		}
	}
	elseif($action == "Delete Shift"){
		$result = $db->delete("DELETE FROM workPeriod WHERE workperiodID=$workperiodID;");
		$_SESSION['shiftAdded'] = "Successfully Deleted working time.";
		$logger->info("Working time has been deleted successfully");
		header("location: ../../businessPageEmployeeEditShift.php");
	}
}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
	$logger->error("Error occured while changing the shift, all fields have to be filled");
	header("location: ../../businessPageEmployeeEditShift.php");
}


/**
 * Function used to check whether the new startDateTime and endDateTime overlaps
 * with any other scheduled workperiod for the same employee.
 */
function checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID){
	include('./databaseClass.inc');
	$check = $db->select("
	select * 
	from workperiod 
	where date('$startDateTime') = date(startDateTime) 
	and employeeID = '$employeeID' 
	and workperiodID <> '$workperiodID'
	and startDateTime <= '$endDateTime'
	and endDateTime >= '$startDateTime';
	");
	if(mysqli_num_rows($check) == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
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
// Rearrange date time into format php and mysql can manipulate.
function dateFormatter($date, $time)
{
	$datePieces = explode("/", $date);
	$combineDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $time:00";
	return date("Y-m-d H:i:s", strtotime($combineDateTime));
}
// Check Valid time
function timeCheck($start, $end)
{
	if($end < $start){
		return false;
	}
	return true;
}
?>