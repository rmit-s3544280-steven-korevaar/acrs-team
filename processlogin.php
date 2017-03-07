<?php
$username = $_POST['username'];
$password = $_POST['password'];

$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
$query = "select * from userTable where username='$username' and password=SHA('$password');";
$results = mysqli_query($connect,$query) or die(mysqli_error($connect));

if(mysqli_num_rows($results) > 0){
	print("Successfully Logged in");
}
else{
	print("Incorrect Username or Password");
}
?>