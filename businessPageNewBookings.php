<?php
$page_title='Business New Bookings';
include('/assets/header.inc');
?>
<!--Body Start--> 
<?php
include('assets/ownerChecker.inc');
include('assets/businessBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<h1>All bookings for the next 7 days</h1>
<table class='centreTable'>
<tr>
<th>Customer Name</th><th>Start date/time</th><th>End date/time</th><th>Extra notes</th>
</tr>
<?php
$connect = mysqli_connect("localhost","root","","SEPT_Assignment_Part_1");
/* Query to Select all bookings between todays date and next 7 days */
$query = "select fullname, startDateTime, endDateTime, otherDetails from user as a inner join booking as b on a.username=b.username where startDateTime between now() and date_add(now(), interval 7 day) order by startDateTime desc;";
$results = mysqli_query($connect,$query);

/* If no results are found, print "No new bookings", else 
 * store the results into a array and print results out by their column names.
 */
if(mysqli_num_rows($results) != 0)
{
	while($row=mysqli_fetch_array($results))
	{
		print "<tr>\n";
		print "<td class='tableStyle'>{$row['fullname']}</td><td class='tableStyle'>{$row['startDateTime']}</td><td class='tableStyle'>{$row['endDateTime']}</td><td class='tableStyle'>{$row['otherDetails']}</td>\n";
		print "</tr>\n";
	}
}
else
{
	print "<table><tr>No new bookings found</tr></table>";
}
?>
</table>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
