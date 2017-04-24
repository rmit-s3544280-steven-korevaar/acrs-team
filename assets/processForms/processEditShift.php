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
/* Instantiate database */
include('./databaseClass.inc');

if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) 
	&& !empty($_POST['workperiodID']))
{
	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$workperiodID = $_POST['workperiodID'];
	$employeeID = $_POST['employeeID'];
	$action = $_POST['action'];
	
	/* Rearrange date time into format which PHP and MySQL can manipulate */
	$datePieces = explode("/", $date);
	$combinestartDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $startTime:00";
	$combineendDateTime = "$datePieces[2]-$datePieces[1]-$datePieces[0] $endTime:00";

	$startDateTime = date("Y-m-d H:i:s", strtotime($combinestartDateTime));
	$endDateTime = date("Y-m-d H:i:s", strtotime($combineendDateTime));
	
	/* Check whether the set End Date Time is after the Start Date Time */
	if($action == "Edit Shift"){
		if($startDateTime < $endDateTime){
			if( checkOverlap($startDateTime, $endDateTime, $employeeID, $workperiodID) == true )
			{
				$result = $db->update("UPDATE workPeriod SET startDateTime='$startDateTime', 
				endDateTime='$endDateTime' WHERE workperiodID=$workperiodID;");
				$_SESSION['shiftAdded'] = "Successfully Edited working time.";
				header("location: ../../businessPageEmployeeEditShift.php");
			}
			else{
				$_SESSION['shiftError'] = "Work Period cannot overlap.";
				header("location: ../../businessPageEmployeeEditShift.php");
			}
		}
		else{
			$_SESSION['shiftError'] = "The end time must be after the start time.";
			header("location: ../../businessPageEmployeeEditShift.php");
		}
	}
	elseif($action == "Delete Shift"){
		$result = $db->delete("DELETE FROM workPeriod WHERE workperiodID=$workperiodID;");
		$_SESSION['shiftAdded'] = "Successfully Deleted working time.";
		header("location: ../../businessPageEmployeeEditShift.php");
	}
}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
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


?>