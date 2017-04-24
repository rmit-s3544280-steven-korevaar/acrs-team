<?php
/* *******************************************************************
 * Author: 	Ryan Tran			s3201690
 *				Asli Yoruk 			s3503519
 * PHP script to generate the page for business owner to add a new
 * employee into the system.
 * 
 ********************************************************************/
$page_title='Business Employee Add new Employee';
include('./assets/header.inc');
?>
<!--Body Start--> 
<?php
include('./assets/ownerChecker.inc');
include('./assets/businessBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<h1>Add new Employee to system</h1>
<p><span class="errorMessage">* required field.</span></p>
<form method='post' action='./assets/processForms/processAddEmployee.php'>
<table class="centreTable">
<tr>
<th>Full name: </th>
<td><input type="text" name="employeeName"/></td>
</tr>
<tr>
<th>Job title: </th>
<td><input type="text" name="jobTitle"/></td>
</tr>
<tr>
<th>Employee Number: </th>
<td><input type="text" name="employeeID"/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Add Employee"/></td></tr>
</table>

<?php
if(isset($_SESSION['returnErrorAddEmployeeMessage']) && !empty($_SESSION['returnErrorAddEmployeeMessage'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='errorMessage'>\n");
	print("<p> {$_SESSION['returnErrorAddEmployeeMessage']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnErrorAddEmployeeMessage']);
}
elseif(isset($_SESSION['returnSuccessAddEmployeeMessage']) && !empty($_SESSION['returnSuccessAddEmployeeMessage'])){
	print("<table class='centreTable'>\n");
	print("<tr><td class='successMessage'>\n");
	print("<p> {$_SESSION['returnSuccessAddEmployeeMessage']} </p>\n");
	print("</td></tr>\n");
	print("</table>\n");
	unset($_SESSION['returnSuccessAddEmployeeMessage']);
}
?>
</form>
</div>
<!--Body End-->
<?php
include('./assets/footer.inc');
?>
