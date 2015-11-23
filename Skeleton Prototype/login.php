<?php 
	require_once("header.php");

	if (isset($_POST['userlogin']) && strlen($_POST['userlogin']) > 0)
	{
            // Find User
            $userstmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
            $un=$_POST["userlogin"];
            $userstmt->execute(array(':un'=>$un));
            $userresults = $userstmt->fetch();
            if (!$userresults)
            {
                    exit("Error: That user does not exist.");
            }
            // Verify Password
            if (password_verify($_POST['passlogin'], $userresults['hash']))
            {
                    $_SESSION['userid'] = $userresults['userID'];
                    $redirect_uri = 'index.php';
                    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
            } else {
                    echo "<p>Login failed.</p>";
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
