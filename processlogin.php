<?php
/*Script to process login.
 *Script will initialise variables for easier manipulation firstly,
 *then check if the user exists in the user table.
 *If a user is found, it will determine whether a user is a customer
 *or a owner and forward the user to the appropriate page.
 */
 
 
/*Initialise variables to able to call easier*/
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
	
	//If a result is found, the user is a owner
	if(mysqli_num_rows($checkResult) > 0){
		header("location:ownerPage.php");	//If is a owner, send to owner management page
	}
	//If nothing is found in the userbusiness table, the user is not a owner, but is just a regular customer
	else{
		header("location:customerPage.php");	//If is a customer, send to customer page
	}
}
else{
	//If incorrect username or password, send back to index.php with a error message.
	session_unset();
	session_start();
	$_SESSION['loginError'] = "! Incorrect username or password, Please try again.";
	header("location:index.php");
}
exit(0);
?>