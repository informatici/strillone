<?
/*
	Copyright© 2012,2013 Informatici Senza Frontiere Onlus
	http://www.informaticisenzafrontiere.org

    This file is part of "ISA" I Speak Again - ISF project for impaired and blind people.

    "ISA" I Speak Again is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    "ISA" I Speak Again is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with "ISA" I Speak Again.  If not, see <http://www.gnu.org/licenses/>.
*/
include "functions.php";
?>
<!DOCTYPE html>

<html lang="it-IT" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Strillone - Spoken News for Visually Impaired People (web version)</title>
	<meta charset="utf-8">

	<script type="text/javascript" src="scripts/jquery.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.ui.js"></script>
	<script type="text/javascript" src="scripts/jquery.jgiornale.js"></script>
	<script type="text/javascript" src="scripts/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.jplayer.inspector.js"></script>

	<script type="text/javascript">
	
	var ttse = 'festival';
	
	<?
	$ttse = 'festival';

	if (isset($_GET['ttse']) && ($_GET['ttse'] == 'ivona')) {
		$ttse = 'ivona';
		echo "ttse = 'ivona';";
	}
	?>

	</script>
	
	<script type="text/javascript" src="scripts/utils.js"></script>
	<link href="css/strillone.css" rel="stylesheet" type="text/css"/>

</head>

<body>
		

<div id="container">

	<div id="jquery_jplayer"></div>
	<div id="upper_left" class="buttons"></div>
	<div id="upper_right" class="buttons"></div>
	<div id="lower_left" class="buttons"></div>
	<div id="lower_right" class="buttons"></div>

</div>

<form name="speechform" id="speechform" method="post" action="ajax_<? echo $ttse; ?>.php">
	<input type="hidden" name="speech" id="speech" />
	<input type="hidden" name="volume_scale" id="volume_scale" value="1"> 
</form>

<div id="jplayer_controls">
<a class="jp-play" href="#">Play</a>
<a class="jp-pause" href="#">Pause</a>
<a class="jp-stop" href="#">Stop</a>
<a class="jp-mute" href="#">Mute</a>
<a class="jp-unmute" href="#">Unmute</a>
<a class="jp-volume-max" href="#">Max</a>
</div>
		
</body>

</html>