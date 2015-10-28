<?php 
	require_once("header.php");
?>

<form name="registerform" action="register.php" method="post">
	<label for="userreg">Username:</label>
	<input name="userreg" type="text" size="20" id="userreg"><br/>
	<laebl for="passreg">Password:</laebl>
	<input name="passreg" type="passreg" id="passreg"><br/>
	<laebl for="passconf">Re-enter Password:</laebl>
	<input name="passconf" type="password" id="passconf"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>