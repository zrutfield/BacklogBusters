<?php

$freetimelengths // array of all free times, as given by user's calendar
= array(0.5, 1, 1.5, 5, 1, 2, 0.5); // *TEST*
$ftl = array(); // optimized version of above
$library // user's library of games
= array('Hatoful Boyfriend', 'Final Fantasy XIV', 'Chroma Squad', 'Unholy Heights'); // *TEST*
$sitting // dictionary of avg. sitting times per game title
= array('Hatoful Boyfriend' => 1, 'Final Fantasy XIV' => 2.5, 'Chroma Squad' => 0.5, 'Unholy Heights' => 0.5); // *TEST*
$played // dictionary of user's time played per game title
= array('Hatoful Boyfriend' => 3, 'Final Fantasy XIV' => 277, 'Chroma Squad' => 9, 'Unholy Heights' => 11); // *TEST*
$overall // dictionary of avg. overall length per game title
= array('Hatoful Boyfriend' => 8.5, 'Final Fantasy XIV' => 812.5, 'Chroma Squad' => 17, 'Unholy Heights' => 11); // *TEST*

//sort & remove duplicates from allfreetimelengths to create ftl
$ftl = array_unique($freetimelengths);
sort($ftl);

$recs = array(); // array of recommendations
// contains subarrays corresponding to # of unique sitting lengths
for (i = 0; i < count($ftl); ++i) {
	array_push($recs, array());
}

// find games to rec
for (i = 0; i < count($library); ++i) {
	if ( ($overall[$library[i]] - $played[$library[i]]) != 0) { // don't rec games that have been completed
		//go through list of possible sitting times to find a match
		for (j = 0; j < count($ftl); ++j) {
			if ($sitting[$library[i]] == $ftl[j]) {
				// add to recs
				if (count($recs[j]) = 0) { array_push($recs[j], $library[i]); }
				else {
					for (k = 0; k < count.($recs[j]); ++k) {
						if (k = count.($recs[j]) - 1) { 
							array_push($recs[j], $library[i]);
							break;
						}
						// prioritize games with less time till completion
						else if ( ($overall[$recs[j][k]] - $played[$recs[j][k]]) > ($overall[$library[i]] - $played[$library[i]] {
							array_splice( $recs, k, 0, $library[i] ); // splice in at position k
							break;
						}
					}
				}
				break;
			}
		}
	}
}

?>