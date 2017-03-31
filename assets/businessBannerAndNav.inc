<div class='headingBannerDiv'>
<h1>Booking Website</h1>
</div>
<!--Navigation Bar for Business Owner-->
<div class='businessNavigationDiv'>
<span>Hello, <?php print "{$_SESSION['username']}" ?>.</span>

<!--BEGIN PHP Drop down box -->
<select id='businessNavigationBooking' onchange='navigateBooking();'>
<option class='noDisplay'>Bookings</option>
<option class='businessNavigationDropDown' value='businessPage.php'>Booking Summaries</option>
<option class='businessNavigationDropDown' value='businessPageNewBookings.php'>New Bookings</option>
</select>

<select id='businessNavigationEmployee' onchange='navigateEmployee();'>
<option class='noDisplay'>Employees</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAvailability.php'>Availability</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAddShift.php'>Add Shift</option>
<option class='businessNavigationDropDown' value='businessPageEmployeeAddEmployee.php'>Add New Employee</option>
</select>
<!--END PHP Drop down box -->

<a href='processLogout.php'>Sign Out</a>
</div>