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
/*Script to process adding new employee.
 *Script will initialise variables for easier manipulation firstly,
 *then insert the new employee into table.
 */

//adding datalogging config 
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");
 
/*Check if input data exists and Initialise variables to call easier*/
session_start();
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
	
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$query = "insert into employee values('$employeeName','$jobTitle','$businessID','$employeeID');";

	if(mysqli_query($connect,$query)){
		//If successful add , send back to businessPageEmployeeAddEmployee.php with success message.
		$logger->info("Owner added an employee");
		$_SESSION['returnSuccessAddEmployeeMessage'] = "Successfully added new Employee.";
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
	else{
	    /* If unsuccessfull, send back to businessPageEmployeeAddEmployee.php with error message.
		  * Employee is already in system.
		  */
	    $logger->error("Owner entered an existing employee");
		$_SESSION['returnErrorAddEmployeeMessage'] = "A employee of that 'Employee Number' is already in the system.";
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
}
else{
	$logger->error("Owner entered something wrong while adding employee");
	$_SESSION['returnErrorAddEmployeeMessage'] = "Please enter data in all fields.";
	header("location: ./../../businessPageEmployeeAddEmployee.php");
}

exit(0);
?>