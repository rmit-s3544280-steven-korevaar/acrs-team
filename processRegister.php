<?php
/*Script to process customer registration.
 *Script will initialise variables for easier manipulation firstly,
 *then insert customer into user table.
 */
 
 
/*Initialise variables to able to call easily*/
$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
$query = "insert into user values('$username','$fullname','$address','$phone',SHA('$password'));";




if(mysqli_query($connect,$query)){
	//If successful register, send back to index.php with success message.
	session_unset();
	session_start();
	$_SESSION['registerSuccess'] = "Register successful, Please login.";
	header("location:index.php");
}
else{//If username already exists, send back to index.php with a error message.
	session_unset();
	session_start();
	$_SESSION['registerError'] = "! That username is unavailable, Please try another.";
	header("location:index.php");
}
exit(0);
?>