<?php

define('STEAM_URL', 'http://api.steampowered.com/');
define('API_KEY', '5542D7D800499D6DD8C36C1F783F7A77');

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

    $response = file_get_contents($requestUrl);
    var_dump($response);

    $responseObject = json_decode($response);
    $gamesList = $responseObject->response->games;
    //print ('Game Name, App ID, Playtime (min)' . "\n");
    //foreach($gamesList as $game) { print $game->name . ', ' . $game->appid . ', ' . $game->playtime_forever . "\n"; }
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
