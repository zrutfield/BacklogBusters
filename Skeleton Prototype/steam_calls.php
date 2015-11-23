<?php
require_once('header.php');

define('STEAM_URL', 'http://api.steampowered.com/');
define('API_KEY', '5542D7D800499D6DD8C36C1F783F7A77');

function syncSteamLibrary($steamID)
{
    $gamesOwned = getGamesList($steamID);
}

function getGamesList($steamID)
{
    $url = STEAM_URL . 'IPlayerService/GetOwnedGames/v0001/';
    $data = array(
        'key' => urlencode(API_KEY),
        'steamid' => urlencode($steamID),
        'format' => urlencode('json'),
        'include_appinfo' => urlencode('1'),
        'include_played_free_games' => urlencode('1'),
    );
    $requestUrl = formatRequestUrl($url, $data); 

    if(!($response = file_get_contents($requestUrl)))
    {
        $steamIDNum = resolveVanityUrl($steamID);
        $data = array(
            'key' => urlencode(API_KEY),
            'steamid' => urlencode($steamIDNum),
            'format' => urlencode('json'),
            'include_appinfo' => urlencode('1'),
            'include_played_free_games' => urlencode('1'),
        );
        $requestUrl = formatRequestUrl($url, $data); 
        $response = file_get_contents($requestUrl);
    }
    $responseObject = json_decode($response);
    $gamesList = $responseObject->response->games;

    return $gamesList;
}

function resolveVanityUrl($steamID)
{
    http://api.steampowered.com/ISteamUser/ResolveVanityURL/v0001/?key=XXXXXXXXXXXXXXXXXXXXXXX&vanityurl=userVanityUrlName
    $url = STEAM_URL . 'ISteamUser/ResolveVanityURL/v0001/';
    $data = array(
        'key' => urlencode(API_KEY),
        'vanityurl' => urlencode($steamID),
    );
    $requestUrl = formatRequestUrl($url, $data); 
    $response = file_get_contents($requestUrl);
    $responseObject = json_decode($response);
    if($responseObject->response->success == 42)
    {
        throw new Exception("Undefined Vanity URL");
    }
    return $responseObject->response->steamid;
}

function formatRequestUrl($url, $data)
{
    $dataString = '?';
    foreach($data as $key=>$value) {$dataString .= $key . '=' . $value .'&'; }
    $dataString = rtrim($dataString, '&');
    $requestUrl = $url . $dataString;
    return $requestUrl;
}

//getGamesList('76561198009798841');
