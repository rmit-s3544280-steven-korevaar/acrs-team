<?php
	/*Recheck if user is a owner*/
	$username = $_SESSION['username'];
	
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$queryOwner= "select * from userbusiness where username like '$username';";
	$checkResult = mysqli_query($connect,$queryOwner) or die(mysqli_error($connect));
	
	if(mysqli_num_rows($checkResult) <= 0){	//If a result is not found send back to login page.
		session_destroy();		//Destroy all session variables in _SESSION[] global array.
		header("location:index.php");	//Send unwanted user back to index.php
	}
?>