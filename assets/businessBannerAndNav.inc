<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *
 * Include file for generating business navigation bar.
 * 
 ********************************************************************/
?>
<div class='headingBannerDiv'>
<h1><?php print "{$_SESSION['businessName']}"; ?> Booking Website</h1>
</div>
<!--Navigation Bar for Business Owner-->
<div class='businessNavigationDiv'>
<span>Hello, <?php print "{$_SESSION['username']}" ?>.</span>

<!--BEGIN PHP Drop down box -->
<select id='businessNavigationBooking' onchange='navigateBooking();'>
<option class='noDisplay'>Bookings</option>
<option class='businessNavigationDropDown' value='businessPage.php'>Booking Summaries</option>
<option class='businessNavigationDropDown' value='businessPageNewBookings.php'>New Bookings</option>
<option class='businessNavigationDropDown' value='businessPageCreateBooking.php'>Create Booking</option>
</select>

<select id='businessNavigationEmployee' onchange='navigateEmployee();'>
<option class='noDisplay'>Business Administration</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAddServices.php'>Add New Service</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAvailability.php'>Availability</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAddShift.php'>Add Shift</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeEditShift.php'>Edit Shift</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAddEmployee.php'>Add New Employee</option>
</select>
<!--END PHP Drop down box -->

<a href='./assets/processForms/processLogout.php'>Sign Out</a>
</div>