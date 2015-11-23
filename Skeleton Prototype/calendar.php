<?php 
	require_once("header.php");
        require_once("vendor/autoload.php");

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

                session_start();

                $client = new Google_Client();
                $client->setAuthConfigFile('../client_secrets.json');
                $client->addScope(Google_Service_Calendar::CALENDAR);

                if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                      $client->setAccessToken($_SESSION['access_token']);
                      $calendar_service = new Google_Service_Calendar($client);
                      $calendarId = 'primary';

                      if ($day == date('l')) {
                        $startDayTime = strtotime('today');
                      } else {
                        $startDayTime = strtotime('next ' . $day);
                      }

                      $startUnixTime = $startDayTime + ($startTime * 60 * 60);
                      $endUnixTime = $startUnixTime + ($duration * 60 * 60);

                      $startDateTime = date('c', $startUnixTime);
                      $endDateTime = date('c', $endUnixTime);

                      $our_event = new Google_Service_Calendar_Event(array(
                        'summary' => 'Backlog Busters',
                        'description' => 'Play <insert game here>',
                        'start' => array(
                          'dateTime' => $startDateTime,
                        ),
                        'end' => array(
                          'dateTime' => $endDateTime,
                        ),
                        'source' => array(
                            'title' => 'BacklogBusters',
                            'url' => 'http://www.backlogbusters.com',
                        ),
                      ));
                      $added_event = $calendar_service->events->insert($calendarId, $our_event);

                } else {
                      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
                      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
                }
        }
?>

<form name="calendarform" action="schedule.php" method="post">
	<label for="day">Enter the Day you want to Play:</label><br/>
	<select name="day" id="day">
		<option>Monday</option>
		<option>Tuesday</option>
		<option>Wednesday</option>
		<option>Thursday</option>
		<option>Friday</option>
		<option>Saturday</option>
		<option>Sunday</option>
	</select><br/>
	<label for="startTime">Start Time (24-Hour):</label>
	<input type="number" name="startTime" id="startTime" min="0" max="24" step="1" value="0"><br/>
	<label for="duration">Duration:</label>
	<input type="number" name="duration" id="duration" min="0" value="0" step="any"><br/>
	<input type="submit" value="Submit"><br/>
</form>

<?php
	require_once("footer.php");
?>
