var freetimelengths // array of all free times, as given by user's calendar
= [0.5, 1, 1.5, 5, 1, 2, 0.5]; // *TEST*
var ftl = []; // optimized version of above
var library // user's library of games
= ['Hatoful Boyfriend', 'Final Fantasy XIV', 'Chroma Squad', 'Unholy Heights']; // *TEST*
var sitting // dictionary of avg. sitting times per game title
= {'Hatoful Boyfriend':[1], 'Final Fantasy XIV':[2.5], 'Chroma Squad':[0.5], 'Unholy Heights':[0.5]}; // *TEST*
var played // dictionary of user's time played per game title
= {'Hatoful Boyfriend':[3], 'Final Fantasy XIV':[277], 'Chroma Squad':[9], 'Unholy Heights':[11]}; // *TEST*
var overall // dictionary of avg. overall length per game title
= {'Hatoful Boyfriend':[8.5], 'Final Fantasy XIV':[812.5], 'Chroma Squad':[17], 'Unholy Heights':[11]}; // *TEST*

//sort & remove duplicates from allfreetimelengths to create ftl
freetimelengths.sort();

for (i = 0; i < freetimelengths.length; ++i) {
	if (i != 0) {
		if (freetimelengths[i] != freetimelengths[i - 1]) { ftl.push(i); }
	}
	else { ftl.push(i); }
}

var recs = []; // array of recommendations
// contains subarrays corresponding to # of unique sitting lengths
for (i = 0; i < ftl.length; ++i) {
	recs.push([]);
}

// find games to rec
for (i = 0; i < library.length; ++i) {
	if ( (overall.(library[i]) - played.(library[i])) != 0) { // don't rec games that have been completed
		//go through list of possible sitting times to find a match
		for (j = 0; j < ftl.length; ++j) {
			if (sitting.(library[i]) == ftl[j]) {
				// add to recs
				if (recs[j].length = 0) { recs[j].push(library[i]); }
				else {
					for (k = 0; k < recs[j].length; ++k) {
						if (k = recs[j].length - 1) { 
							recs[j].push(library[i]);
							break;
						}
						// prioritize games with less time till completion
						else if ( (overall.(recs[j][k]) - played.(recs[j][k])) > (overall.(library[i]) - played.(library[i]) {
							recs[j].splice(k, 0, library[i]);
							break;
						}
					}
				}
				break;
			}
		}
	}
}