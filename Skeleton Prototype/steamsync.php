<?php
	$id_bb; // user's backlog busters id *NOT IMPLEMENTED*
	$id_steam; // user's steam id *NOT IMPLEMENTED*
	$gameslist; // backlog busters' database of games *NOT IMPLEMENTED*
	$library_bb; // backlog busters' library for the given user; get using id_bb *NOT IMPLEMENTED*
	$library_steam; // steam's library for the given user; get using GetOwnedGames from the Steam API *NOT IMPLEMENTED* 

	for ($i = 0; $i < count($library_steam); ++$i) {
		$isfinished = false;
		for ($j = 0; $j < count($library_bb); ++$j) {
			if ($library_bb[$j].id == $library_steam[$j].id) { // don't actually know how to get the game id?  *INCORRECT*
				//update the played time *NOT IMPLEMENTED*
				$isfinished = true;
				break;
			}
		}
		if (isfinished == true) {
			ownedgames.pop($i); // probably *INCORRECT*
			break;

		}
		else {
			for ($j = 0; $j < count($gameslist); ++$j) {
				if ($library_bb[$j].id == $library_steam[$j].id) { // don't actually know how to get the game id?  *INCORRECT*
					// add to user library (w/ playtime) *NOT IMPLEMENTED*
					$isfinished = true;
					break;
				}
			}
		}
		if (isfinished == true) {
			ownedgames.pop($i); // probably *INCORRECT*
			break;

		}
		else {
			// add to $gameslist *NOT IMPLEMENTED*
			// add to user library (w/ playtime) *NOT IMPLEMENTED*
		}
	}
?>