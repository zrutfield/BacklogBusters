<?php 
	require_once("header.php");
?>

<form name="loginform" action="login.php" method="post">
	<label for="userlogin">Username:</label>
	<input name="userlogin" type="text" size="20" id="userlogin"><br/>
	<laebl for="passlogin">Password:</laebl>
	<input name="passlogin" type="password" id="passlogin"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>