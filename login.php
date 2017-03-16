<?php
$page_title='Login';
include('/assets/header.inc');
?>
<!--Body Start-->
<h1>Login</h1>
<form action='processlogin.php' method='post'>
<table>
<tr>
<th>Username: </th>
<td><input type="text" name="username" />
</tr>
<tr>
<th>Password: </th>
<td><input type="password" name="password" />
</tr>
<tr>
<th />
<td>
<input type="submit" name="Login" />
</td>
</tr>
</table>
</form>
<!--Body End-->
<?php
include('assets/footer.inc');
?>
