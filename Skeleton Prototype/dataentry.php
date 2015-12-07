<?php 
	require_once("header.php");

	//If the form has been filled out, perform the data entry operation.
	if (isset($_POST["gamename"]) && strlen($_POST["gamename"]) > 0)
	{
		//Grab the game from the games table.
		$stmt=$dbconn->prepare("SELECT * FROM `games` WHERE `gamename`=:gn");
      	$gn=$_POST["gamename"];
      	$stmt->execute(array('gn'=>$gn));
      	$results = $stmt->fetch();
      	//If the game is not found in the table, add an entry for it.
      	if (!$results) 
      	{	
	      	$totalTTB=$_POST['TTB'];
	      	$TTBEntries=1;
	      	$totalSession=$_POST['sessiontime'];
	      	$sessionEntries=1;
      		$stmt=$dbconn->prepare("INSERT INTO `games` (`gamename`,`totalTTB`,`TTBEntries`,`totalSession`,`sessionEntries`) VALUES (:gamename,:totalTTB,:TTBEntries,:totalSession,:sessionEntries)");
      		$stmt->execute(array(':gamename'=>$gn,':totalTTB'=>$totalTTB,':TTBEntries'=>$TTBEntries,':totalSession'=>$totalSession,':sessionEntries'=>$sessionEntries));
      	}
      	//Else, update the game's data.
      	else
      	{
	      	$resultsid=$results['gameID'];
	      	$totalTTB=floatval($results['totalTTB']) + floatval($_POST['TTB']);
	      	$TTBEntries=floatval($results['TTBEntries']) + 1;
	      	$totalSession=floatval($results['totalSession']) + floatval($_POST['sessiontime']);
	      	$sessionEntries=floatval($results['sessionEntries']) + 1;
	      	$stmt=$dbconn->prepare("UPDATE `games` SET `totalTTB`=:totalTTB, `TTBEntries`=:TTBEntries, `totalSession`=:totalSession, `sessionEntries`=:sessionEntries WHERE `gameid`=:gameid");
	      	$stmt->execute(array(':totalTTB'=>$totalTTB,':TTBEntries'=>$TTBEntries,':totalSession'=>$totalSession,':sessionEntries'=>$sessionEntries,':gameid'=>$resultsid));
      	}
	}
?>

<!--The form to take the game's data.-->
<form name="dataentryform" action="dataentry.php" method="post">
	<label for="gamename">Game:</label>
	<input type="text" name="gamename" id="gamename"><br/>
	<label for="sessiontime">Session Time:</label>
	<input type="number" name="sessiontime" id="sessiontime" min=0 step="any"><br/>
	<label for="TTB">Completion Time:</label>
	<input type="number" name="TTB" id="TTB" min=0 step="any"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>
