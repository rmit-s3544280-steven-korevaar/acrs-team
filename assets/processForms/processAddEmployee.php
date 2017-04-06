<?php
/*Script to process adding new employee.
 *Script will initialise variables for easier manipulation firstly,
 *then insert the new employee into table.
 */
 
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
		$_SESSION['returnSuccessAddEmployeeMessage'] = "Successfully added new Employee.";
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
	else{
	    /* If unsuccessfull, send back to businessPageEmployeeAddEmployee.php with error message.
		  * Employee is already in system.
		  */
		$_SESSION['returnErrorAddEmployeeMessage'] = "A employee of that 'Employee Number' is already in the system.";
		header("location: ./../../businessPageEmployeeAddEmployee.php");
	}
}
else{
	$_SESSION['returnErrorAddEmployeeMessage'] = "Please enter data in all fields.";
	header("location: ./../../businessPageEmployeeAddEmployee.php");
}

exit(0);
?>