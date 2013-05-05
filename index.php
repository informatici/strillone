<?php

/*
 * This file is part of the Strillone package.
 *
 * (c) Informatici Senza Frontiere Onlus <http://informaticisenzafrontiere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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

    <?php
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

<form name="speechform" id="speechform" method="post" action="ajax_<?php echo $ttse; ?>.php">
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
