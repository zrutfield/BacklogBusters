<?php
	try 
	{
	  $host = 'localhost';
	  $root = 'root';
	  $password = '';

	  $dbconn = new PDO("mysql:host=$host;dbname=backlogbusters;",$root,$password);

	} catch (PDOException $e) 
	{
	  die("Database Error: ". $e->getMessage());
	}
        session_start();
?>

<html>
	<head>
	 <title>BacklogBusters</title>
	 <meta charset="utf-8">
	 <link href="backlog.css" rel="stylesheet">
	</head>

        <body>
                <?php
                if(isset($_SESSION['userid']))
                {
                    $getUserStmt = $dbconn->prepare("SELECT `username` from `users` WHERE `userID`=:userid");
                    $getUserStmt->execute(array(':userid'=>$_SESSION['userid']));
                    $results = $getUserStmt->fetch();
                    echo '<div id="login">' . $results['username'] . '<a href=logout.php> (Log Out)</a>' . '</div>';
                } else {
                    echo '<div id="login"><a href="login.php">Login</a>/<a href="register.php">Register</a></div>';
                    print $_SESSION['userid'];
                } ?>

            
		<h1>BacklogBusters</h1>
		<ul id="menulist">
			<li><a href="index.php">Home</a></li>
			<li><a href="account.php">Account</a></li>
			<li><a href="calendar.php">Calendar</a></li>
			<!--<li><a href="schedule.php">Schedule</a></li>-->
			<li><a href="dataentry.php">Enter Data</a></li>
			<li><a href="stats.php">Stats</a></li>
		</ul>
