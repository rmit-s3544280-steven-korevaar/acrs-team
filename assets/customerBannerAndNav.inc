<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * Include file for generating customer navigation bar.
 * 
 ********************************************************************/
?>
<div class='headingBannerDiv'>
<h1><?php print "{$_SESSION['businessName']}"; ?> Booking Website</h1>
</div>
<!--Navigation Bar for Customer-->
<div class='customerNavigationDiv'>
<span>Hello, <?php print "{$_SESSION['username']}" ?>.</span>
<a href='customerPage.php'>Show Booking Summaries</a>
<a href='customerBooking.php'>Make a new Booking</a>
<a href='assets/processForms/processLogout.php'>Sign Out</a>
</div>