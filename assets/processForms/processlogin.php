<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * PHP script used to process the user login.
 *
 * The script will check if the username AND password combination 
 * exists in the user table.
 *
 * If not it will redirect back to the login page with a error 
 * message.
 *
 * If it does, check whether if it a business owner or a customer, and
 * redirect appropriately.
 * 
 ********************************************************************/

$username = $_POST['username'];
$password = $_POST['password'];

$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
$query = "select * from user where username='$username' and password=SHA('$password');";
$results = mysqli_query($connect,$query) or die(mysqli_error($connect));


if(mysqli_num_rows($results) > 0){
	//Check to see if it is a customer or a owner
	$queryOwner= "select * from userbusiness where username like '$username';";
	$checkResult = mysqli_query($connect,$queryOwner) or die(mysqli_error($connect));
	
	
	//Store username in the global array under the username variable, for future use.
	session_start();
	$_SESSION['username'] = "$username";
	
	//Get ABN for customer processBooking.php
	$getABNquery = "select ABN from business;";
	$ABNresults = mysqli_query($connect,$getABNquery) or die(mysqli_error($connect));
	if(mysqli_num_rows($ABNresults) != 0)
	{
		while($ABN=mysqli_fetch_array($ABNresults))
		{
			
			$_SESSION['abn'] = "{$ABN['ABN']}";
		}
	}
	
	if(mysqli_num_rows($checkResult) > 0){	//If a result is found, check to see if the user is a owner.
		header("location: ../../businessPage.php");	//If is a owner, send to owner management page
	}
	
	else{	//If nothing is found in the userbusiness table, the user is not a owner, but is just a regular customer
		header("location: ../../customerPage.php");	//If is a customer, send to customer page
	}
}
else{
	//If incorrect username or password, send back to index.php with a error message.
	session_unset();
	session_start();
	$_SESSION['loginError'] = "! Incorrect username or password, Please try again.";
	header("location: ../../index.php");
}
exit(0);
?>