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

/*Check if input data exists and Initialise variables to call easier*/
$checkForData = array('employeeName','jobTitle','employeeID');
$checkFlag = true;
foreach($checkForData as $data){
	if(empty($_POST[$data])){
		$checkFlag = false;
	}
}
/*If all data exists, continue with the adding employee process*/
if($checkFlag == true){
	$employeeName = $_POST['employeeName'];
	$jobTitle = $_POST['jobTitle'];
	$employeeID = $_POST['employeeID'];
	$businessID = $_SESSION['abn'];
	
	$result = $db->insert("insert into employee values('$employeeName','$jobTitle','$businessID','$employeeID');");

	if($result != false){
		//If successful add, send back to businessPageEmployeeAddEmployee.php with success message.
		$_SESSION['returnSuccessAddEmployeeMessage'] = "Successfully added new Employee.";
		$logger->info("Owner succes added a new employee");
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
	else{
	    /* If unsuccessfull, send back to businessPageEmployeeAddEmployee.php with error message.
		  * Employee is already in system.
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

exit(0);
?>