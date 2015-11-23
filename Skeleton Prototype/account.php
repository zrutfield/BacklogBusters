<?php
require_once('header.php');
require_once('steam_calls.php');

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
        if(isset($_POST['steamid']) && strlen($_POST['steamid']) > 0)
        {
            $steamID = $_POST['steamid'];
            $gameList = getGamesList($steamID);
            $gameStmt = $dbconn->prepare("SELECT * from `games` WHERE `gameID`=:steamID");
            $gameStmt->execute(array(':steamID'=>$steamID));
            foreach($gameList as $game) {
                if (!($gameObject = $gameStmt->fetch())) {
                    $insertGameStmt=$dbconn->prepare("INSERT INTO `games` (`gameID`, `gamename`,`totalTTB`,`TTBEntries`,`totalSession`,`sessionEntries`) VALUES (:gameid, :gamename,:totalTTB,:TTBEntries,:totalSession,:sessionEntries)");
                    $insertGameStmt->execute(array(':gameid' =>$game->appid,
                                                   ':gamename'=> $game->name,
                                                   ':totalTTB' => 0,
                                                   ':TTBEntries' => 0,
                                                   ':totalSession' => 0,
                                                   ':sessionEntries' => 0,
                                            ));
                }
                $userGameStmt = $dbconn->prepare("SELECT * from `usergamerelations` WHERE `UserID`=:userid AND `GameID`=:gameid");
                $userGameStmt->execute(array(':userid' => $userid,
                                             ':gameid' => $game->appid,
                                       ));
                if ($gameObject = $userGameStmt->fetch())
                {
                    if($gameObject-> timePlayed != $game->playtime_forever / 60.0)
                    {
                        $userGameStmt = $dbconn->prepare("UPDATE `usergamerelations` SET `timePlayed`=:timePlayed WHERE `UserID`=:userid AND `GameID`=:gameid");
                        $userGameStmt->execute(array(':userid' => $userid,
                                                     ':gameid' => $game->appid,
                                                     ':timePlayed' => $game->playtime_forever / 60.0,
                                               ));
                    }
                } else {
                    $relationStmt=$dbconn->prepare("INSERT INTO `usergamerelations` (`UserID`, `GameID`, `timePlayed`) VALUES (:userid,:gameid,:timePlayed)");
                    $relationStmt->execute(array(':userid' => $userid,
                                                 ':gameid' => $game->appid,
                                                 ':timePlayed' => $game->playtime_forever / 60.0,
                                           ));
                }

            }
        }
    }
?>


<form name="steamform" action="account.php" method="post">
	<label for="username">Enter your Username:</label>
	<input type="text" name="username" id="username"><br/>
	<label for="steamid">Enter your Steam ID:</label>
	<input type="text" name="steamid" id="steamid"><br/>
	<input type="submit" value="Submit"><br/>
</form>

<?php
	require_once("footer.php");
?>
