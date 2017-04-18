<?php
require_once('./Database.php');

//Database object
$db = new Database();
$name = "admin1";
$password = "admin";

$result = $db->select("SELECT * FROM user where username = 'asdsa';");
//$result = $db->select("SELECT ABN FROM business;");
if(mysqli_num_rows($result) != 0)
{
	print "Something found\n";
	while($row=mysqli_fetch_array($result))
	{
		print "</br>{$row['username']}:{$row['fullname']}";
	}
}
else
{
	print "Nothing found";
}

/*
$employeeName = "New Guy";
$jobTitle = "Clipper, Washer & Stylist";
$businessID = "56497978719";
$employeeID = "004";

//Check with error return
$insert = $db->insert("INSERT INTO employee values ('$employeeName','$jobTitle','$businessID','$employeeID');");
if ($insert === false)
{
	$error = $db->error();
	print ($db->error());
}
*/
?>