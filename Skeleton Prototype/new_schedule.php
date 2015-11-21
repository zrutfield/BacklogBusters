<?php
require_once('header.php');

if (isset($_GET['starttime']) && isset($_GET['endtime']) && isset($_GET['userid']) ) {
    $startTime = $_GET['starttime'];
    $endTime = $_GET['endtime'];
    $userId = $_GET['userid'];

    $duration = $endTime - $startTime;

    $getGamesStatement = $dbconn->prepare("SELECT 'GameID' from 'usergamerelations' WHERE 'UserID'=:userid");
    $getGamesStatement->execute(array(':userid' => userId));
    $userLibrary = $getGamesStatement->fetch();
    

    //session_start();

    //$client = new Google_Client();
    //$client->setAuthConfigFile('../client_secrets.json');
    //$client->addScope(Google_Service_Calendar::CALENDAR);

    //if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    //      $client->setAccessToken($_SESSION['access_token']);
    //      $calendar_service = new Google_Service_Calendar($client);
    //      $calendarId = 'primary';

    //      $startDateTime = date('c', $startTime);
    //      $endDateTime = date('c', $endTime);

    //      $our_event = new Google_Service_Calendar_Event(array(
    //        'summary' => 'Backlog Busters',
    //        'description' => 'Play <insert game here>',
    //        'start' => array(
    //          'dateTime' => $startDateTime,
    //        ),
    //        'end' => array(
    //          'dateTime' => $endDateTime,
    //        ),
    //      ));
    //      $added_event = $calendar_service->events->insert($calendarId, $our_event);

    //}
}

function makeRecommendation($duration)
{

}



require_once('footer.php');

