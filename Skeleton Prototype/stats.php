<?php 
	require_once("header.php");

	if (isset($_POST['gamename']) && $_POST['gamename'])
	{
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gameName`=:gn");
		$gn=$_POST["gamename"];
		$stmt->execute(array(':gn'=>$gn));
		$results = $stmt->fetch();
		print_r($results);
	}
	else if (isset($_POST['sessiontime']) && $_POST['sessiontime'])
	{
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gamename`=:gn");
		$gn=$_POST["gamename"];
		$stmt->execute(array(':gn'=>$gn));
		$results = $stmt->fetch();
		print_r($results);
	}
	else if (isset($_POST['completiontime']) && $_POST['completiontime'])
	{
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gamename`=:gn");
		$gn=$_POST["gamename"];
		$stmt->execute(array(':gn'=>$gn));
		$results = $stmt->fetch();
		print_r($results);
	}
?>

<form name="searchname" action="stats.php" method="post">
	<label for="gamename">Search by Game:</label>
	<input type="text" name="gamename" id="gamename">
	<input type="submit" value="Search">
</form>

<form name="searchsession" action="stats.php" method="post">
	<label for="sessiontime">Search by Session Time:</label>
	<input type="number" name="sessiontime" id="sessiontime">
	<input type="submit" value="Search">
</form>

<form name="searchcompletion" actoin="stats.php" method="post">
	<label for="completiontime">Search by Completion Time:</label>
	<input type="number" name="completiontime" id="completiontime">
	<input type="submit" value="Search">
</form>

<?php
	require_once("footer.php");
?>