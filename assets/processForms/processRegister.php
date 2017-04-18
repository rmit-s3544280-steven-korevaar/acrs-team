<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process customer registration after Register
 * button is clicked on.
 *
 * The script will validate whether the input data is valid for MySQL
 * query/insertion, insert into the database and return a success
 * message. 
 * 
 * If it is not valid it will return a error message to the user.
 ********************************************************************/
 
/*Script to process customer registration.
 *Script will initialise variables for easier manipulation firstly,
 *then insert customer into user table.
 */
 
//adding datalogging config 
include('../../datalogging/Logger.php');
Logger::configure('../../config.xml');
$logger = Logger::getLogger("main");

/*Check if input data exists and Initialise variables to call easier*/

$checkForData = array('username','password','fullname','address','phone');
$checkFlag = true;
foreach($checkForData as $data){
	if(empty($_POST[$data])){
		$checkFlag = false;
	}
}
/*If all data exists, continue with the register process*/
if($checkFlag == true){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$fullname = $_POST['fullname'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$query = "insert into user values('$username','$fullname','$address','$phone',SHA('$password'));";

	if(mysqli_query($connect,$query)){
		//If successful register, send back to index.php with success message.
		$logger->info("Customer registration is successful");
		session_unset();
		session_start();
		$_SESSION['registerSuccess'] = "Register successful, Please login.";
		header("location: ../../index.php");
	}
	else{//If username already exists, send back to index.php with a error message.
		$logger->error("Customer registration is unsuccessful, username already exists");
		session_unset();
		session_start();
		$_SESSION['registerError'] = "! That username is unavailable, Please try another.";
		header("location: ../../index.php");
	}
}
else{
	$logger->error("Customer registration is unsuccessful, all fields are required");
	session_unset();
	session_start();
	$_SESSION['returnData'] = array($_POST['username'],$_POST['password'],$_POST['fullname'],$_POST['address'],$_POST['phone']);
	$_SESSION['registerError'] = "! All fields are required.";
	header("location: ../../index.php");
}

exit(0);
?>