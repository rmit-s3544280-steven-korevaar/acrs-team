<?php
/* *******************************************************************
 * Author: 	Ryan Tran				s3201690
 *					Asli Yoruk				s3503519
 *					Steven Korevaar 	s3544280
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
require_once('processes.php');
require_once('../helpers.php');

/*If all data exists, continue with the adding employee process*/
if( checkInputData() == true ){
	$employeeName = $_POST['employeeName'];
	$jobTitle = $_POST['jobTitle'];
	$employeeID = $_POST['employeeID'];
	$businessID = $_SESSION['abn'];
	
	processes::addEmployee($employeeName, $jobTitle, $employeeID, $businessID, $db, $logger);
	
}
else{
	$_SESSION['returnErrorAddEmployeeMessage'] = "Please enter data in all fields.";
	$logger->error("Error occured while owner trying to add a new employee, all fields need to be filled ");
	header("location: ./../../businessPageEmployeeAddEmployee.php");
}

/* Function used to check if input data was posted sent to this php via _POST */
function checkInputData(){
	$checkForData = array('employeeName','jobTitle','employeeID');
	foreach($checkForData as $data){
		if(empty($_POST[$data])){
			return false;
		}
	}
	return true;
}

exit(0);
?>