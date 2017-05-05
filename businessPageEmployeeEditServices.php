<?php
/* *******************************************************************

 * PHP script to generate the page for customer booking.
 * Uses a plugin from FullCalendar.io.
 * 
 ********************************************************************/
	$page_title='Edit Services';
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
<h1>Edit Services</h1>
service 1			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/><br/>
service 2			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/><br/>
service 3			<input type="submit" value="Edit"/> <input type="submit" value="Delete"/>




<!-- I want to show all the existing services and put a edit and delete options next to it,
	and a quick text line at the end to quick add services -->

<!--Body End-->
<?php
include('./assets/footer.inc');
?>
