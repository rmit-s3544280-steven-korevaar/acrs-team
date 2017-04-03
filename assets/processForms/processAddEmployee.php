<?php
/*Script to process customer registration.
 *Script will initialise variables for easier manipulation firstly,
 *then insert customer into user table.
 */
 
/*Check if input data exists and Initialise variables to call easier*/

$checkForData = array('name','title','businessID','employeeNum');
$checkFlag = true;
foreach($checkForData as $data){
	if(empty($_POST[$data])){
		$checkFlag = false;
	}
}
/*If all data exists, continue with the register process*/
if($checkFlag == true){
	$name = $_POST['name'];
	$employeeNum = $_POST['employeeNum'];
	$title = $_POST['title'];
	$businessID = $_POST['businessID'];
	
	$connect = mysqli_connect("localhost","root","","sept_assignment_part_1") or die(mysqli_error($connect));
	$query = "insert into employee values('$name','$title','$businessID','$employeeNum',);";

	if(mysqli_query($connect,$query)){
		//If successful register, send back to index.php with success message.
		
	}
	else{
	    //If username already exists, send back to index.php with a error message.
		
	}
}
else{
	
}

exit(0);
?>