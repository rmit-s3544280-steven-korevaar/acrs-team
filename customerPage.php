<?php
$page_title='Customer Booking Summaries';
<<<<<<< HEAD
include('assets/header.inc');
=======
include('./assets/header.inc');
>>>>>>> e80d16953a163b25af08f7d1b25f71f8c25e3407
?>
<!--Body Start--> 
<?php
include('./assets/customerBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<h1>Your Booking Summaries</h1>
<table class='centreTable' border = '1px solid black'>
<tr><th>Start Date/Time</th><th>End Date/Time</th><th>Extra Notes</th></tr>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "SEPT_Assignment_Part_1";
    
    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    //Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT startDateTime, endDateTime, otherDetails, username FROM booking WHERE username = '".$_SESSION['username']."' order by startDateTime desc;";
    $results = $conn->query($sql);

	 if(mysqli_num_rows($results) != 0)
	 {
	 	while($row=mysqli_fetch_array($results))
		{
			$retrievedStartDate = strtotime($row['startDateTime']);
			$startConverted = date('g:iA j-F-Y',$retrievedStartDate);
			$retrievedEndDate = strtotime($row['endDateTime']);
			$endConverted = date('g:iA j-F-Y',$retrievedEndDate);
			print "<tr>\n";
			print "<td class='tableStyle'>$startConverted</td><td class='tableStyle'>$endConverted</td><td class='tableStyle'>{$row['otherDetails']}</td>\n";
			print "</tr>\n";
		}
	 }
	 else
	 {
		print "<table><tr>No bookings found</tr></table>";
	 }
    $conn->close();
?>
</table>
</div>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>

