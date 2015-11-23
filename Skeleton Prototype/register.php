<?php 
	require_once("header.php");

	if (isset($_POST['userreg']) && strlen($_POST["userreg"]) > 0)
	{
                // Make sure passwords match
		if (strcmp($_POST['passreg'],$_POST['passconf']) != 0)
		{
			exit("Error: Passwords do not match.");
		}

                // Check to see if username already exists
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
                        // Add User to DB
			$un = $_POST['userreg'];
			$pass = $_POST['passreg'];
                        // Hash Password using a random salt
                        $hash = password_hash($pass, PASSWORD_DEFAULT);
			$userstmt=$dbconn->prepare("INSERT INTO `users` (`username`,`hash`) VALUES (:un,:hash)");
			$userstmt->execute(array(':un'=>$un,':hash'=>$hash));

                        // Log in the newly created user
                        $userIDStmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
                        $userIDStmt->execute(array(':un'=>$un));
                        $userresults = $userIDStmt->fetch();
                        session_start();
                        $_SESSION['userid'] = $userresults['userID'];
                        $redirect_uri = 'index.php';
                        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

		}
	}
?>

<form name="registerform" action="register.php" method="post">
	<label for="userreg">Username:</label>
	<input name="userreg" type="text" size="20" id="userreg"><br/>
	<label for="passreg">Password:</label>
	<input name="passreg" type="password" id="passreg"><br/>
	<label for="passconf">Re-enter Password:</label>
	<input name="passconf" type="password" id="passconf"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>
