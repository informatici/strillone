var giornale_url = 'http://www.informaticisenzafrontiere.org/feed/';
var giornale = new Array();

var tree_level = 'sezione';
var sezione_position = -1;
var articolo_position = -1;

var	my_jPlayer;

$(document).ready(function() {

	// Local copy of jQuery selectors, for performance.
	my_jPlayer = $("#jquery_jplayer");

	// Some options
	var	opt_play_first = false, // If true, will attempt to auto-play the default track on page loads. No effect on mobile devices, like iOS.
		opt_auto_play = true, // If true, when a track is selected, it will auto-play.
		opt_text_playing = "Now playing", // Text when playing
		opt_text_selected = "Track selected"; // Text when not playing

	// A flag to capture the first track
	var first_track = true;

	// Instance jPlayer
	my_jPlayer.jPlayer({
		swfPath: "scripts",
		cssSelectorAncestor: "#container",
		supplied: "mp3",
		solution:"flash,html",
		wmode: "window"
	});

	$('#container').width($(window).width());
	$('#container').height($(window).height());
	
	$('.buttons').bind('click',function(e) {
		naviga(e);
	});
	
    jQuery.getGiornale({
//		url: 'get_feed.php?url=' + escape(giornale_url),
        url: 'get_feed.php?url=./feeds/bol_20121120.xml',
        success: function(feed) {
			giornale['edizione'] = feed.edizione;
			giornale['sezioni'] = feed.sezioni;
			
			for (i=0; i<giornale['sezioni'].length; i++) {
				giornale['sezioni'][i]['articoli'] = feed.sezioni[i].articoli;
			}
			
        }
    });

});

function naviga(event) {
	switch(event.target.id) {
	
		case 'upper_left':
			sezione_position = -1;
			articolo_position = -1;
			tree_level = 'sezione';
			blindnews_tts("Inizio navigazione.");
		break;
	
		case 'lower_left':
		switch (tree_level) {
			case 'sezione':
			if (giornale['sezioni'][sezione_position]['articoli'].length > 0) {
				tree_level = 'articolo';
				articolo_position = -1;
				blindnews_tts("Sei entrato nella " + giornale['sezioni'][sezione_position]['nome']);
			} else {
				blindnews_tts("La sezione " + giornale['sezioni'][sezione_position]['nome'] + " non contiene articoli");
			}
			break;
			
			case 'articolo':
			blindnews_tts(giornale['sezioni'][sezione_position]['articoli'][articolo_position]['testo']);
			break;
		}
		break;
		
		case 'upper_right':
		switch (tree_level) {
			case 'sezione':
			sezione_position--;
			if (sezione_position < 0) {
				sezione_position = 0;
			}
			blindnews_tts(giornale['sezioni'][sezione_position]['nome']);
			break;
			
			case 'articolo':
			articolo_position--;
			if (articolo_position < 0) {
				articolo_position = 0;
			}
			blindnews_tts(giornale['sezioni'][sezione_position]['articoli'][articolo_position]['titolo']);
			break;

		}
		break;

		case 'lower_right':
		switch (tree_level) {
			case 'sezione':
			articolo_position = 0;
			sezione_position++;
			if (sezione_position > giornale['sezioni'].length) {
				sezione_position = giornale['sezioni'].length;
			}
			blindnews_tts(giornale['sezioni'][sezione_position]['nome']);
			break;
			
			case 'articolo':
			articolo_position++;
			if (articolo_position > giornale['sezioni'][sezione_position]['articoli'].length) {
				articolo_position = (giornale['sezioni'][sezione_position]['articoli'].length);
			}
			blindnews_tts(giornale['sezioni'][sezione_position]['articoli'][articolo_position]['titolo']);
			break;

		}
		break;

	}
}

function blindtext_tts(testo) {
	my_jPlayer.jPlayer("setMedia", {
		mp3: "./audiobase/" + testo
	}).jPlayer("play");
}

function blindnews_tts(testo) {
// alert(testo);
 	$('#speech').val(testo);
	$.post('ajax_festival.php', $('#speechform').serialize(), function(msg) {
		my_jPlayer.jPlayer("setMedia", {
			mp3: "./audio/" + msg
		}).jPlayer("play");
	});
	return false;
}