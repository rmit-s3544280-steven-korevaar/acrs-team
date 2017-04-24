<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 * 			Christine Huynh	s3438653
 *
 * PHP script to generate the landing page after customer logs
 * in. Displays the customer booking summaries.
 * 
 ********************************************************************/
$page_title='Customer Booking Summaries';
include('./assets/header.inc');
/* Instantiate database connection object, called $db */
include('./assets/databaseClass.inc');
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
	$results = $db->select("SELECT startDateTime, endDateTime, otherDetails, username FROM 
	booking WHERE username = '".$_SESSION['username']."' order by startDateTime desc;");
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
?>
</table>
</div>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>

