<?php
$page_title='Login';
include('/assets/header.inc');
?>
<!--Body Start--> 
<div class='centreContentBodyInDiv'>
<!--Login Portion of index.php-->
<div id='loginForm'>
<div class='formBorder'>
<h1>Login</h1>
<form method='post' action='processlogin.php'>
<table class="centreTable">
<tr>
<th>Username: </td>
<td><input type="text" name="username"/></td>
</tr>
<tr>
<th>Password: </td>
<td><input type="password" name="password"/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Login"/></td></tr>
</table>
</form>
</div>
</div>

<!--Register Portion of index.php-->
<div id='registerForm'>
<div class='formBorder'>
<h1>Customer Register</h1>

<form method="post" action="processRegister.php">
<table class="centreTable">
<tr>
<th>Username: </td>
<td><input type="text" name="username"/></td>
</tr>
<tr>
<th>Password: </td>
<td><input type="password" name="password"/></td>
</tr>
<tr>
<th>Full name: </td>
<td><input type="text" name="fullname"/></td>
</tr>
<tr>
<th>Address: </td>
<td><input type="text" name="address"/></td>
</tr>
<tr>
<th>Phone Number: </td>
<td><input type="text" name="phone"/></td>
</tr>
</table>
<table class="centreTable">
<tr><td><input type="submit" value="Register"/></td></tr>
</table>
</form>
</div>
</div>

</div>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
