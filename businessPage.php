<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 * 			Christine Huynh	s3438653
 *
 * PHP script to generate the landing page after business owner logs
 * in.
 * 
 ********************************************************************/
	$page_title='Business Page';
	include('./assets/header.inc');
	/* Instantiate database connection object, called $db */
	include('./assets/databaseClass.inc');
?>
<!--Body Start--> 
<?php
	include('./assets/ownerChecker.inc');
	include('./assets/businessBannerAndNav.inc');
?>

<div class='contentHereDiv'>
<h1>Booking Summaries</h1>
<table class='centreTable' border = '1'>
<tr><th>Date</th><th>Start Time</th><th>End Time</th><th>Customer Name</th><th>Service</th><th>Extra Notes</th></tr>
<?php
	$results = $db->select("select bookingID,fullname, startDateTime, endDateTime, otherDetails from user as a 
	inner join booking as b on a.username=b.username WHERE businessID = '{$_SESSION['abn']}' order by startDateTime asc;");
	if(mysqli_num_rows($results) != 0)
	{
		while($row=mysqli_fetch_array($results))
		{
			$retrievedStartDate = strtotime($row['startDateTime']);
			$date = date('j-F-Y',$retrievedStartDate);
			$startConverted = date('g:iA',$retrievedStartDate);
			$retrievedEndDate = strtotime($row['endDateTime']);
			$endConverted = date('g:iA',$retrievedEndDate);
			$bookingID = $row['bookingID'];
			print "<tr>\n";
			print "<td class='tableStyle'>$date</td>
			<td class='tableStyle'>$startConverted</td>
			<td class='tableStyle'>$endConverted</td>
			<td class='tableStyle'>{$row['fullname']}</td>
			<td><table>";
			//Get activies for the particular booking
			$activityResults = $db->select("select activityName from businessactivity where activityID in (select activityID from bookingactivity where bookingID = '$bookingID');"); 
			while($activityRow=mysqli_fetch_array($activityResults))
			{
				print "<tr><td>{$activityRow['activityName']}</tr></td>";
			}
			print "</table></td>
			<td class='tableStyle'>{$row['otherDetails']}</td>\n";
			print "</tr>\n";
		}
	}
	else
	{
		print "<table><tr><h2>No bookings found.<h2></tr></table>";
	}
?>
</table>
</div>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>
