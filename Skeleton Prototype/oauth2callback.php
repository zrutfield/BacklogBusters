<?php
require_once 'vendor/autoload.php';

// Start browser session
session_start();

// Initiate the Google Calendar Client
$client = new Google_Client();
// Load the API Authorization key
$client->setAuthConfigFile('../client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR);

// If no user authorization set, redirect to the authorization page
if (! isset($_GET['code'])) {
      $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
      // If user has authorized access, save the key for the session
      // Then redirect to calendar.php
      $client->authenticate($_GET['code']);
        $_SESSION['access_token'] = $client->getAccessToken();
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/calendar.php';
          header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
