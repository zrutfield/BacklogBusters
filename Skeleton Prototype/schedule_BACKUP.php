<?php 
	require_once("header.php");

	$freetimelengths // array of all free times, as given by user's calendar
		= array(0.5, 1, 1.5, 5, 1, 2, 0.5); // *TEST*
	//echo "freetimelengths: "; // *TEST*
	//print("<pre>".print_r($freetimelengths,true)."</pre>"); // *TEST*
	$library // user's library of games
		= array('Chroma Squad', 'Final Fantasy XIV', 'Hatoful Boyfriend', 'Skullgirls', 'Unholy Heights', 'Undertale'); // *TEST*
	//echo "<br> library: "; // *TEST*
	//print("<pre>".print_r($library,true)."</pre>"); // *TEST*
	$sitting // dictionary of avg. sitting times per game title
		= array('Hatoful Boyfriend' => 1, 'Final Fantasy XIV' => 2.5, 'Chroma Squad' => 0.5, 'Unholy Heights' => 0.5, 
		'Undertale' => 0.5, 'Skullgirls' => 0.5); // *TEST*
	//echo "<br> sitting: "; // *TEST*
	//print("<pre>".print_r($sitting,true)."</pre>"); // *TEST*
	$played // dictionary of user's time played per game title
		= array('Hatoful Boyfriend' => 3, 'Final Fantasy XIV' => 277, 'Chroma Squad' => 9, 'Unholy Heights' => 5, 
		'Undertale' => 3, 'Skullgirls' => 4); // *TEST*
	//echo "<br> played: "; // *TEST*
	//print("<pre>".print_r($played,true)."</pre>"); // *TEST*
	$overall // dictionary of avg. overall length per game title
		= array('Hatoful Boyfriend' => 8.5, 'Final Fantasy XIV' => 812.5, 'Chroma Squad' => 17, 'Unholy Heights' => 11, 
		'Undertale' => 13, 'Skullgirls' => 16.5); // *TEST*
	//echo "<br> overall: "; // *TEST*
	//print("<pre>".print_r($overall,true)."</pre>"); // *TEST*

	//sort & remove duplicates from allfreetimelengths to create ftl
	$ftl = array(); // optimized version of freetimelengths
	$ftl = array_unique($freetimelengths);
	sort($ftl);
	//echo "ftl: "; // *TEST*
	//print("<pre>".print_r($ftl,true)."</pre>"); // *TEST*

	$recs = array(); // array of recommendations
	// contains subarrays corresponding to # of unique sitting lengths
	for ($i = 0; $i < count($ftl); ++$i) {
		$recs[strval($ftl[$i])] = array();
	}
	//echo "recs: "; // *TEST*
	//print("<pre>".print_r($recs,true)."</pre>"); // *TEST*

	// find games to rec
	for ($i = 0; $i < count($library); ++$i) {
		if ( ($overall[$library[$i]] - $played[$library[$i]]) != 0) { // don't rec games that have been completed
			//go through list of possible sitting times to find a match
			for ($j = 0; $j < count($ftl); ++$j) {
				if ($sitting[$library[$i]] == $ftl[$j]) {
					// add to recs
					//echo $library[$i]; echo " is a match for slot "; echo $ftl[$j]; echo "! <br>"; // *TEST*
					if (count($recs[strval($ftl[$j])]) == 0) { 
						array_push($recs[strval($ftl[$j])], $library[$i]); 
						//echo "..."; echo $library[$i]; echo " was the first match! <br>"; // *TEST*
					}
					else {
						//echo "..."; echo $library[$i]; echo " wasn't the first match! <br>"; // *TEST*
						for ($k = 0; $k < count($recs[strval($ftl[$j])]); ++$k) {
							//echo "......Comparing "; echo $library[$i]; echo " with ";  // *TEST*
							//echo $recs[strval($ftl[$j])][$k]; echo ": it's "; // *TEST*
							//echo $overall[$library[$i]] - $played[$library[$i]]; echo " vs "; // *TEST*
							//echo $overall[$recs[strval($ftl[$j])][$k]] - $played[$recs[strval($ftl[$j])][$k]]; echo "! <br>"; // *TEST*
							// prioritize games with less time till completion
							if ( ($overall[$recs[strval($ftl[$j])][$k]] - $played[$recs[strval($ftl[$j])][$k]]) 
							> ($overall[$library[$i]] - $played[$library[$i]])) {
								//echo "......"; echo $recs[strval($ftl[$j])][$k]; echo " had more time left, so "; // *TEST*
								//echo $library[$i]; echo " goes first! <br>"; // *TEST*
								array_splice( $recs[strval($ftl[$j])], $k, 0, $library[$i] ); // splice in at position k
								break;
							}
							else if ($k == count($recs[strval($ftl[$j])]) - 1) {
								array_push($recs[strval($ftl[$j])], $library[$i]);
								break;
							}
						}
					}
					break;
				}
			}
		}
	}
	
	print("<pre>".print_r($recs,true)."</pre>"); // *TEST*

	require_once("footer.php");
?>