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

include 'config.php';

// all'inizio della pagina
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

if (is_numeric($_GET['edizione'])) {

$time = mktime(0,0,0,substr($_GET['edizione'],4,2),substr($_GET['edizione'],6,2),substr($_GET['edizione'],0,4));
setlocale(LC_TIME, 'it_IT');
$new_date = strftime('%A, %d %B %Y',$time); 

$wrong_string = array("%","<TAB>","<i>","<I>","</i>","</I>","<b>","<B>","</b>","</B>","<br>","<BR>","<BR />","<BR/>","&nbsp;","&#146;","&#171;","&#187;","&");
$right_string = array(" %","","","","","","","","",""," "," "," "," "," ","'","'","'","e");

$xml = "<?xml version='1.0' encoding='UTF-8'?>
	<giornale>
	<testata>Brescia on line</testata>
	<edizione>" . $new_date . "</edizione>";

$query = "SELECT * FROM articoli WHERE (edizione = '" . $_GET['edizione'] . "') AND (sezione != '') AND (testo != '') AND ((occhiello != '') OR (titolo != '') OR (sottotitolo != '')) ORDER BY sezione;";

$result = mysql_query($query) or $esito = mysql_error();

$sezione_attiva = '';

$i = 0;
$j = 0;


while ($linea = mysql_fetch_array($result, MYSQL_ASSOC)) {

	if ($linea['sezione'] != $sezione_attiva) {

		$i++;
		$j = 0;
		
		if ($i > 1) {
			$xml .= "</sezione>";
		}
	
		$xml .= "<sezione>
			<nome>Sezione " . $i . ": " . $linea['sezione'] . "</nome>";

	}
	
	$j++;
	$xml .= "
			<articolo>
				<titolo>Articolo " . $j . ": " . trim(str_replace($wrong_string, $right_string, $linea['occhiello'])) . " " . trim(str_replace($wrong_string, $right_string, $linea['titolo'])) . " " . trim(str_replace($wrong_string, $right_string, $linea['sottotitolo'])) . "</titolo>
				<testo>" . trim(str_replace($wrong_string, $right_string, $linea['testo'])) . "</testo>
			</articolo>\n";
			

	$sezione_attiva = $linea['sezione'];

}

$xml .= "	</sezione>
</giornale>";

header('Content-Type: text/xml; charset=utf-8');
echo($xml);
 
} else {
	echo "errore";
}
 
// da normalizzare in futuro gli articoli di questi tipi:
// "SELECT * FROM articoli WHERE sezione = '';
// "SELECT * FROM articoli WHERE testo = '';"
// "SELECT COUNT(*) FROM articoli WHERE (edizione = '20121120') AND ((occhiello = '') OR (titolo = '') OR (sottotitolo = ''));"
 
?>