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
<tr><th>Customer Name</th><th>Start Date/Time</th><th>End Date/Time</th><th>Extra Notes</th></tr>
<?php
	$results = $db->select("select fullname, startDateTime, endDateTime, otherDetails from user as a 
	inner join booking as b on a.username=b.username order by startDateTime asc;");
	if(mysqli_num_rows($results) != 0)
	{
		while($row=mysqli_fetch_array($results))
		{
			$retrievedStartDate = strtotime($row['startDateTime']);
			$startConverted = date('g:iA j-F-Y',$retrievedStartDate);
			$retrievedEndDate = strtotime($row['endDateTime']);
			$endConverted = date('g:iA j-F-Y',$retrievedEndDate);
			print "<tr>\n";
			print "<td class='tableStyle'>{$row['fullname']}</td><td class='tableStyle'>$startConverted</td><td class='tableStyle'>$endConverted</td><td class='tableStyle'>{$row['otherDetails']}</td>\n";
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
