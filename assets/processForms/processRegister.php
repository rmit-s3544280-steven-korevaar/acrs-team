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
/* Instantiate database */
include('./databaseClass.inc');

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
	
	$result = $db->insert("insert into user values('$username','$fullname','$address','$phone',SHA('$password'));");
	if($result != false){
		//If successful register, send back to index.php with success message.
		$_SESSION['registerSuccess'] = "Register successful, Please login.";
		header("location: ../../index.php");
	}
	else{//If username already exists, send back to index.php with a error message.
		$_SESSION['registerError'] = "! That username is unavailable, Please try another.";
		header("location: ../../index.php");
	}
}
else{
	$_SESSION['returnData'] = array($_POST['username'],$_POST['password'],$_POST['fullname'],$_POST['address'],$_POST['phone']);
	$_SESSION['registerError'] = "! All fields are required.";
	header("location: ../../index.php");
}

exit(0);
?>