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

/*If all data exists, continue with the adding employee process*/
if( checkInputData() == true ){
	$employeeName = $_POST['employeeName'];
	$jobTitle = $_POST['jobTitle'];
	$employeeID = $_POST['employeeID'];
	$businessID = $_SESSION['abn'];
	
	// Search existing employeeID, employeeID must not be existing in system.
	if( searchExistingEmployeeID($db,$employeeID) == false ){
		$result = $db->insert("insert into employee values('$employeeName','$jobTitle','$businessID','$employeeID');");
		//If successful add, send back to businessPageEmployeeAddEmployee.php with success message.
		$_SESSION['returnSuccessAddEmployeeMessage'] = "Successfully added new Employee.";
		$logger->info("Owner succes added a new employee");
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
	else{
	    /* If unsuccessfull, send back to businessPageEmployeeAddEmployee.php with error message.
		  * EmployeeID is already in system.
		  */
		$_SESSION['returnErrorAddEmployeeMessage'] = "A employee of that 'Employee Number' is already in the system.";
		$logger->error("Error occured while owner trying to add a new employee, employee number already exists");
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
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
function searchExistingEmployeeID($db,$employeeID){
	$result = $db->select("SELECT * FROM employee where employeeID = '$employeeID';");
	if( mysqli_fetch_array($result) == null ){
		return false;
	}
	return true;
}
exit(0);
?>