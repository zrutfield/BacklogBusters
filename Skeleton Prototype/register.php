<?php 
	require_once("header.php");

	if (isset($_POST['userreg']) && strlen($_POST["userreg"]) > 0)
	{
		if (strcmp($_POST['passreg'],$_POST['passconf']) != 0)
		{
			exit("Error: Passwords do not match.");
		}
		$userstmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
		$un=$_POST["userreg"];
		$userstmt->execute(array(':un'=>$un));
		$userresults = $userstmt->fetch();
		if ($userresults)
		{
			exit("Error: That username is already taken.");
		}
		else
		{
			$un = $_POST['userreg'];
			$pass = $_POST['passreg'];
			$salt = "lsdkfj";
			$userstmt=$dbconn->prepare("INSERT INTO `users` (`username`,`pass`,`salt`) VALUES (:un,:pass,:salt)");
			$userstmt->execute(array(':un'=>$un,':pass'=>$pass,':salt'=>$salt));
		}
	}
?>

<form name="registerform" action="register.php" method="post">
	<label for="userreg">Username:</label>
	<input name="userreg" type="text" size="20" id="userreg"><br/>
	<laebl for="passreg">Password:</laebl>
	<input name="passreg" type="password" id="passreg"><br/>
	<laebl for="passconf">Re-enter Password:</laebl>
	<input name="passconf" type="password" id="passconf"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>