<?php 
	require_once("header.php");

	if (isset($_POST['userlogin']) && strlen($_POST['userlogin']) > 0)
	{
		if (isset($_POST['username']) && strlen($_POST["username"]) > 0)
		{
			$userstmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
			$un=$_POST["userlogin"];
			$userstmt->execute(array(':un'=>$un));
			$userresults = $userstmt->fetch();
			if (!$userresults)
			{
				exit("Error: That user does not exist.");
			}
			if (strcmp($userresults['pass'],$_POST['pass']) == 0)
			{
				echo "<p>Login Successful! Welcome, ".$un."!</p>";
			}
			else
			{
				echo "<p>Login failed.</p>";
			}
		}
	}
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