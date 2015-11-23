<?php
	//Establish the database connection.
	try 
	{
	  $host = 'localhost';
	  $root = 'root';
	  $password = '';

	  //PDOs are a safe and secure method of accessing a database.
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
                //Display the login/register or logout button(s) depending on if the user is logged in or not.
                if(isset($_SESSION['userid']))
                {
                    $getUserStmt = $dbconn->prepare("SELECT `username` from `users` WHERE `userID`=:userid");
                    $getUserStmt->execute(array(':userid'=>$_SESSION['userid']));
                    $results = $getUserStmt->fetch();
                    echo '<div id="login">' . $results['username'] . '<a href=logout.php> (Log Out)</a>' . '</div>';
                } else {
                    echo '<div id="login"><a href="login.php">Login</a>/<a href="register.php">Register</a></div>';
                    print $_SESSION['userid'];
                } 
                ?>

            
		<h1>BacklogBusters</h1>
		<!--The menu bar that tops every page.-->
		<ul id="menulist">
			<li><a href="index.php">Home</a></li>
			<li><a href="account.php">Account</a></li>
			<li><a href="calendar.php">Calendar</a></li>
			<li><a href="dataentry.php">Enter Data</a></li>
			<li><a href="stats.php">Stats</a></li>
		</ul>
