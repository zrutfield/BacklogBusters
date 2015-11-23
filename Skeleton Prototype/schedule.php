<?php
require_once('header.php');
require_once('game.php');
require_once("vendor/autoload.php");

if (isset($_POST) && !empty($_POST) ) {

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

    $getLibraryStatement = $dbconn->prepare("SELECT * from `usergamerelations` WHERE `UserID`=:userid");
    $getLibraryStatement->execute(array(':userid' => $userid));
    
    $userLibrary = array();
    while($game = $getLibraryStatement->fetch(PDO::FETCH_ASSOC))
    {
        $gameID = $game['GameID'];
        $timePlayed = $game['timePlayed'];

        $getGameStatement = $dbconn->prepare("SELECT * from `games` WHERE `gameID`=:gameID");
        $getGameStatement->execute(array(':gameID' => $gameID));
        $libraryGame = $getGameStatement->fetch(PDO::FETCH_ASSOC);

        $gameName = $libraryGame['gameName'];
        if($libraryGame['TTBEntries'] == 0 || $libraryGame['sessionEntries'] == 0) { continue; }
        $timeToBeat = $libraryGame['totalTTB'] / $libraryGame['TTBEntries'];
        $sessionTime = $libraryGame['totalSession'] / $libraryGame['sessionEntries'];

        $gameObject = new Game($gameName, $gameID, $timeToBeat, $sessionTime, $timePlayed);
        array_push($userLibrary, $gameObject);
    }
    $recommendations = makeRecommendations($userLibrary, array($duration));
    foreach($recommendations as $key=>$value)
    {
        print $key . ":    ";
        echo '<br />';
        foreach($value as $game)
        {
            print  $game->gameName;
            echo '<br />';
        }
        echo '<br />';
    }
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
            'description' => 'Play',
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

} else {
    print "Please set a time to play under Calendar\n";
}

function makeRecommendations($library, $durations)
{
    $recommendations = array();
    $freetimeList = array_unique($durations);
    
    foreach($freetimeList as $freetime)
    {
        $recommendations[$freetime] = array();
    }

    foreach($library as $game)
    {
        if($game->timePlayed < $game->timeToBeat)
        {
            foreach($freetimeList as $freetime)
            {
                $thresh = 0.25;
                if($freetime <= (1 + $thresh) * $game->timeOfSitting && $freetime >= (1 - $thresh) * $game-> timeOfSitting)
                {
                    if (count($recommendations[$freetime]) == 0) { 
                        array_push($recommendations[$freetime], $game); 
                    } else {
                        for ($k = 0; $k < count($recommendations[$freetime]); ++$k) {
                            // prioritize games with less time till completion
                            $comparedGame = $recommendations[$freetime][$k];
                            if ($comparedGame->timeToBeat - $comparedGame->timePlayed > $game->timeToBeat - $game->timePlayed) {
                                array_splice( $recommendations[$freetime], $k, 0, array($game)); // splice in at position k
                                break;
                            } else if ($k == count($recommendations[$freetime]) - 1) {
                                array_push($recommendations[$freetime], $game);
                                break;
                            }
                        }
                    }
                    break;
                }
            }
        }
    }
    return $recommendations;
}



require_once('footer.php');

