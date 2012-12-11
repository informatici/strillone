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

?>
