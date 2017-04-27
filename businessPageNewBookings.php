<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 * PHP script to generate the page for business owner to display any
 * future bookings for the next 7 days.
 * 
 ********************************************************************/
$page_title='Business New Bookings';
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
<h1>All bookings for the next 7 days</h1>
<table class='centreTable' border = '1px solid black'>
<tr><th>Date</th><th>Start Time</th><th>End Time</th><th>Customer Name</th><th>Services</th><th>Extra Notes</th></tr>
<?php
/* Query to Select all bookings between todays date and next 7 days */
$results = $db->select("select bookingID, fullname, startDateTime, endDateTime, otherDetails from user as a 
inner join booking as b on a.username=b.username where startDateTime between date(now()) 
and date_add(date(now()), interval 7 day) order by startDateTime asc;");

/* If no results are found, print "No new bookings", else 
 * store the results into a array and print results out by their column names.
 */
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
	print "<table><tr><h2>No new bookings found<h2></tr></table>";
}
?>
</table>
</div>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>
