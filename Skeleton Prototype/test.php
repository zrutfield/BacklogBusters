<?php
require_once 'vendor/autoload.php';
 
session_start();

$client = new Google_Client();
$client->setAuthConfigFile('../client_secrets.json');
$client->addScope(Google_Service_Calendar::CALENDAR);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
      $client->setAccessToken($_SESSION['access_token']);
      $calendar_service = new Google_Service_Calendar($client);
      $calendarId = 'primary';

      $our_event = new Google_Service_Calendar_Event(array(
        'summary' => 'Fallout 4 | Backlog Busters',
        'description' => 'Play Fallout 4',
        'start' => array(
          'dateTime' => '2015-11-10T09:00:00',
          'timeZone' => 'America/New_York',
        ),
        'end' => array(
          'dateTime' => '2015-11-10T17:00:00',
          'timeZone' => 'America/New_York',
        ),
      ));
      $added_event = $calendar_service->events->insert($calendarId, $our_event);

      $optParams = array(
          'maxResults' => 10,
          'orderBy' => 'startTime',
          'singleEvents' => true,
          'timeMin' => date('c'),
          );
      $events_list = $calendar_service->events->listEvents($calendarId, $optParams);
      if (count($events_list->getItems()) == 0) {
        print("No upcoming events found.\n");
      } else {
        print("Upcoming Events\n") ;
        foreach ($events_list->getItems() as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
              $start = $event->start->date;
            }
            printf("%s (%s)\n\n", $event->getSummary(), $start);
            print ' ';
            }
      }
      $calendar = $calendar_service->calendars->get($calendarId);
} else {
      #$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
      $redirect_uri =  'oauth2callback.php';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
