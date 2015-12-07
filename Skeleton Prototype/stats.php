<?php 
	require_once("header.php");

	#if any of the forms have been filled out, performs the search
	if (isset($_POST['gameName']) && $_POST['gameName'])
	{
		#retrieve any games from the games table whose gameName matches the query
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gameName` LIKE :gn");
		$gn=$_POST["gamename"];
		$stmt->execute(array(':gn'=>'%' .  $gn . '%'));
		$results = $stmt->fetch();
		print_r($results);
	}
	else if (isset($_POST['sessionTime']) && $_POST['sessionTime'])
	{
		#retrieve any games from the games table whose sessionTime matches the query
		#NOTE: the sessionTime variable is not currently implemented in the database, due to an oversight.
		#This could be added easily, but feature development is frozen at the moment.
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `sessionTime`=:st");
		$st=$_POST["sessionTime"];
		$stmt->execute(array(':st'=>$st));
		$results = $stmt->fetch();
		print_r($results);
	}
	else if (isset($_POST['completionTime']) && $_POST['completionTime'])
	{
		#retrieve any games from the games table whose completionTime matches the query
		#NOTE: the completionTime variable is not currently implemented in the database, due to an oversight.
		#This could be added easily, but feature development is frozen at the moment.
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `completionTime`=:ct");
		$ct=$_POST["completionTime"];
		$stmt->execute(array(':ct'=>$ct));
		$results = $stmt->fetch();
		print_r($results);
	}
?>

<!--The search form for finding a game's statistics by looking for its name.-->
<form name="searchName" action="stats.php" method="post">
	<label for="gameName">Search by Game:</label>
	<input type="text" name="gameName" id="gameName">
	<input type="submit" value="Search">
</form>

<!--The search form for finding all games with a certain session time.-->
<form name="searchsession" action="stats.php" method="post">
	<label for="sessionTime">Search by Session Time:</label>
	<input type="number" name="sessionTime" id="sessionTime">
	<input type="submit" value="Search">
</form>

<!--The search form for finding all games with a certain completion time.-->
<form name="searchCompletion" action="stats.php" method="post">
	<label for="completionTime">Search by Completion Time:</label>
	<input type="number" name="completionTime" id="completionTime">
	<input type="submit" value="Search">
</form>

<?php
	require_once("footer.php");
?>
