<?php 
	require_once("header.php");

	if (isset($_POST["gamename"]) && strlen($_POST["gamename"]) > 0)
	{
		$userstmt=$dbconn->prepare("SELECT * FROM `users` WHERE `username`=:un");
		$un=$_POST["username"];
		$userstmt->execute(array(':un'=>$un));
		$userresults = $userstmt->fetch();
		$userid = null;
		if (!$userresults)
		{
			exit("Error: user not found.");
		}
		else
		{
			$userid = $userresults['userID'];
		}

		$gamestmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gamename`=:gn");
      	$gn=$_POST["gamename"];
      	$gamestmt->execute(array('gn'=>$gn));
      	$gameresults = $gamestmt->fetch();
      	$gameid = null;

      	if (!$gameresults) 
      	{
      		$totalTTB=0;
	      	$TTBEntries=0;
	      	$totalSession=0;
	      	$sessionEntries=0;
      		$gamestmt=$dbconn->prepare("INSERT INTO `games` (`gamename`,`totalTTB`,`TTBEntries`,`totalSession`,`sessionEntries`) VALUES (:gamename,:totalTTB,:TTBEntries,:totalSession,:sessionEntries)");
      		$gamestmt->execute(array(':gamename'=>$gn,':totalTTB'=>$totalTTB,':TTBEntries'=>$TTBEntries,':totalSession'=>$totalSession,':sessionEntries'=>$sessionEntries));
      		$gamestmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gamename`=:gn");
      		$gamestmt->execute(array('gn'=>$gn));
      		$gameresults = $gamestmt->fetch();
      		$gameid = $gameresults['gameID'];
      	}
      	else
      	{
      		$gameid = $gameresults['gameID'];
      	}

      	$timePlayed = $_POST['gametime'];
      	$gamestmt=$dbconn->prepare("INSERT INTO `usergamerelations`(`UserID`, `GameID`, `timePlayed`) VALUES (:userID,:gameID,:timePlayed)");
      	$gamestmt->execute(array(':gameID'=>$gameid,':userID'=>$userid,':timePlayed'=>$timePlayed));
    }
?>

<h2>Enter Games you Own:</h2>
<form name="gameentryform" action="account.php" method="post">
	<label for="gamename">Game Name:</label>
	<input type="text" name="gamename" id="gamename"><br/>
	<label for="gametime">Time Played:</label>
	<input type="number" name="gametime" id="gametime"><br/>
	<label for="username">Enter your Username:</label> <!--NOTE: This is temporary until session data storage is implemented-->
	<input type="text" name="username" id="username"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>