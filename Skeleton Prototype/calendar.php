<?php 
	require_once("header.php");

	if (isset($_POST['username']) && strlen($_POST["username"]) > 0)
	{
		$userstmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
		$un=$_POST["username"];
		$userstmt->execute(array(':un'=>$un));
		$userresults = $userstmt->fetch();
		if (!$userresults)
		{
			exit("Error: That user does not exist.");
		}

		$userid = $userresults['userID'];
		$day = $_POST['day'];
		$startTime = $_POST['startTime'];
		$duration = $_POST['duration'];
		$timestmt=$dbconn->prepare("INSERT INTO `gametimes`(`UserID`, `day`, `startTime`, `duration`) VALUES (:userid,:day,:startTime,:duration)");
		$timestmt->execute(array(':userid'=>$userid,':day'=>$day,':startTime'=>$startTime,'duration'=>$duration));
	}
?>

<form name="calendarform" action="calendar.php" method="post">
	<label for="username">Enter your Username:</label>
	<input type="text" name="username" id="username"><br/>
	<label for="day">Enter the Day you want to Play:</label><br/>
	<select name="day" id="day">
		<option>Monday</option>
		<option>Tuesday</option>
		<option>Wednsday</option>
		<option>Thursday</option>
		<option>Friday</option>
		<option>Saturday</option>
		<option>Sunday</option>
	</select><br/>
	<label for="startTime">Start Time (24-Hour):</label>
	<input type="number" name="startTime" id="startTime" min="0" max="24" step="1" value="0"><br/>
	<label for="duration">Duration:</label>
	<input type="number" name="duration" id="duration"><br/>
	<input type="submit" value="Submit"><br/>
</form>

<?php
	require_once("footer.php");
?>