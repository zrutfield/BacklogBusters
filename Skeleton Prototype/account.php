<?php
require_once('header.php');
require_once('steam_calls.php');

    if (isset($_SESSION['userid']) && isset($_POST['steamid']) && strlen($_POST["steamid"]) > 0)
    {
        $userid = $_SESSION['userid'];
        $steamID = $_POST['steamid'];
        // Get List of Steam Games
        $gameList = getGamesList($steamID);
        $gameStmt = $dbconn->prepare("SELECT * from `games` WHERE `gameID`=:steamID");
        $gameStmt->execute(array(':steamID'=>$steamID));
        foreach($gameList as $game) {
            // If game has not been imported into the database already, add it
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
            // Add user ownership of game
            $userGameStmt = $dbconn->prepare("SELECT * from `usergamerelations` WHERE `UserID`=:userid AND `GameID`=:gameid");
            $userGameStmt->execute(array(':userid' => $userid,
                                         ':gameid' => $game->appid,
                                   ));
            if ($gameObject = $userGameStmt->fetch())
            {
                // Update if game is already listed as owned and playtime changed
                if($gameObject-> timePlayed != $game->playtime_forever / 60.0)
                {
                    $userGameStmt = $dbconn->prepare("UPDATE `usergamerelations` SET `timePlayed`=:timePlayed WHERE `UserID`=:userid AND `GameID`=:gameid");
                    $userGameStmt->execute(array(':userid' => $userid,
                                                 ':gameid' => $game->appid,
                                                 ':timePlayed' => $game->playtime_forever / 60.0,
                                           ));
                }
            } 
            else 
            {
                $relationStmt=$dbconn->prepare("INSERT INTO `usergamerelations` (`UserID`, `GameID`, `timePlayed`) VALUES (:userid,:gameid,:timePlayed)");
                $relationStmt->execute(array(':userid' => $userid,
                                             ':gameid' => $game->appid,
                                             ':timePlayed' => $game->playtime_forever / 60.0,
                                       ));
            }

        }
    } 
    else if(isset($_POST['steamid']) && strlen($_POST["steamid"]) > 0) 
    {
        print "Please Log In";
    }
?>

<!--The form to take in their steam ID or vanity URL.-->
<form name="steamform" action="account.php" method="post">
	<label for="steamid">Enter your Steam ID:</label>
	<input type="text" name="steamid" id="steamid"><br/>
	<input type="submit" value="Submit"><br/>
</form>

<?php
	require_once("footer.php");
?>
