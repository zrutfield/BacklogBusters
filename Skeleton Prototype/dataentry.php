<?php 
	require_once("header.php");
?>

<form name="dataentryform" action="dataentry.php" method="post">
	<label for="gamename">Game:</label>
	<input type="text" name="gamename" id="gamename"><br/>
	<label for="sessiontime">Session Time:</label>
	<input type="number" name="sessiontime" id="sessiontime"><br/>
	<label for="completiontime">Completion Time:</label>
	<input type="number" name="completiontime" id="completiontime"><br/>
	<input type="submit" value="Submit">
</form>

<?php
	require_once("footer.php");
?>