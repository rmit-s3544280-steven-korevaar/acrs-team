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
	
	processes::editShift($date, $startTime, $endTime, $workPeriodID, $employeeID, $action, $db, $logger);
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