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
$tmpdir = "/var/www/walks/strillone/tmp";
$audiodir = "/var/www/walks/strillone/audio";

// $_POST["speech"] è il testo da sintetizzare
if (isset($_POST["speech"]) && ($_POST["speech"] != '')) {

    // tolgo eventuali spazi iniziali e finali
    $speech = stripslashes(trim($_POST["speech"]));

    // regolo il volume
    $volume_scale = intval($_POST["volume_scale"]);
    if ($volume_scale <= 0) { $volume_scale = 1; }
    if ($volume_scale > 100) { $volume_scale = 100; }

    // continuo solo se il testo esiste
    if ($speech != "") {

        // genero un nome per il file di testo accertandomi che contenga solo caratteri leciti
        $filename = substr($speech,0,64);
        $filename = strtolower(trim($filename));
        $filename = preg_replace("/[^a-zA-Z0-9]/", "", $filename);

        // creo il file che conterrà  il testo
        $speech_file = $tmpdir . "/s_" . $filename;

        // creo i 2 file audio, non compresso e compresso
        $wave_file = $audiodir . "/w_" . $filename . ".wav";
        $mp3_file  = $audiodir . "/m_" . $filename . ".mp3";

        // apro il file temporaneo e vi scrivo il testo
        if (!file_exists($speech_file)) {
            $fh = fopen($speech_file, "w+");

            if ($fh) {
                fwrite($fh, utf8_encode($speech));
                fclose($fh);
            }
        }

        // se il file è stato creato correttamente, creo il wav di sintesi
        if (file_exists($speech_file)) {

            $recode_cmd = "recode utf8..lat1 " . $speech_file . " " . $speech_file . " -f";
            exec($recode_cmd);

            $text2wave_cmd = sprintf("text2wave -eval \"(voice_pc_mbrola) (Parameter.set 'Duration_Stretch 22.5)\" -o %s -scale %d %s",$wave_file,$volume_scale,$speech_file);
            exec($text2wave_cmd);

            //ENGLISH
            // voice_kal_diphone

            // ITALIAN
            // voice_pc_mbrola
            // voice_lp_mbrola
            // voice_pc_diphone
            // voice_lp_diphone

            // converto il file creato da wav in mo3
            $lame_cmd = sprintf("lame %s %s",$wave_file,$mp3_file);
            exec($lame_cmd);

            // cancello il file wav
            unlink($wave_file);

            // delete the temp speech file
            // unlink($speech_file);

            // which file name and type to use? WAV or MP3
            $listen_file = basename($mp3_file);

        }
    }

    $return_value = $listen_file;

    header('Content-Type: text/html');
    echo $return_value;

}
