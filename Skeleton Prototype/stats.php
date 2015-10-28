<?php 
	require_once("header.php");
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