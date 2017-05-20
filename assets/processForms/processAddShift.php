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
require_once('processes.php');

if (isset($_POST['date']) && !empty($_POST['startTime']) && !empty($_POST['endTime']) && !empty($_POST['employeeID']))
{

	$date = $_POST['date'];
	$startTime = $_POST['startTime'];
	$endTime = $_POST['endTime'];
	$employeeID = $_POST['employeeID'];
	
	processes::addShift($date, $startTime, $endTime, $employeeID, $db, $logger);
}
else
{
	$_SESSION['shiftError'] = "Please enter in all fields.";
	$logger->error("Error occured while trying to add shift, all fields have to be filled");
	header("location: ../../businessPageEmployeeAddShift.php");
} 

?>