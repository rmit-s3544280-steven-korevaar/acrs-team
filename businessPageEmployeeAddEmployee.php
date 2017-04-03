<?php
$page_title='Business Employee Add new Employee';
//include('assets/header.inc');
?>
<!--Body Start--> 
<?php
//include('assets/ownerChecker.inc');
//include('assets/businessBannerAndNav.inc');
?>
<div class='contentHereDiv'>
<p>Some Content of Employee adding new Employee</p>


<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="/processForms/processAddEmployee.php">  
  Name: <input type="text" name="name" value="">
  <br><br>
  employeeNum: <input type="text" name="employeeNum" value="">
  <br><br>
  businessID: <input type="text" name="businessID" value="">
  <br><br>
  Title: <input type="text" name="title" value="">
  <br><br>

  <input type="submit" name="submit" value="Submit">  
</form>


</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
