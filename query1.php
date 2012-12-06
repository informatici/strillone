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

$wrong_string = array("<TAB>","<i>","<I>","</i>","</I>","<b>","<B>","</b>","</B>","<br>","<BR>","<BR />","<BR/>","&nbsp;","&#146;","&#171;","&#187;","&");
$right_string = array("","","","","","","","",""," "," "," "," "," ","'","'","'","e");

$xml = "<?xml version='1.0' encoding='UTF-8'?>
<brescia_on_line>";

$query_edizioni = "SELECT DISTINCT edizione FROM articoli ORDER BY edizione DESC;";
$result_edizioni = mysql_query($query_edizioni) or $esito = mysql_error();

while ($linea_edizioni = mysql_fetch_array($result_edizioni, MYSQL_ASSOC)) {

$xml .= "
<giornale>
	<edizione>" . $linea_edizioni['edizione'] . "</edizione>";

$query_sezioni = "SELECT DISTINCT sezione FROM articoli WHERE edizione = '" . $linea_edizioni['edizione'] . "';";
$result_sezioni = mysql_query($query_sezioni) or $esito = mysql_error();

while ($linea_sezioni = mysql_fetch_array($result_sezioni, MYSQL_ASSOC)) {
$xml .= "
	<sezione>
		<nome>" . $linea_sezioni['sezione'] . "</nome>";
			$query_articoli = "SELECT id_articolo,titolo,sottotitolo,testo,occhiello FROM articoli WHERE sezione = '" . $linea_sezioni['sezione'] . "' AND edizione = '" . $linea_edizioni['edizione'] . "' AND titolo != '' AND testo != '';";
			$result_articoli = mysql_query($query_articoli) or $esito = mysql_error();
			while ($linea_articoli = mysql_fetch_array($result_articoli, MYSQL_ASSOC)) {
				$xml .= "
		<articolo>
			<occhiello>" . trim(str_replace($wrong_string, $right_string, $linea_articoli['occhiello'])) . "</occhiello>
			<titolo>" . trim(str_replace($wrong_string, $right_string, $linea_articoli['titolo'])) . "</titolo>
			<sottotitolo>" . trim(str_replace($wrong_string, $right_string, $linea_articoli['sottotitolo'])) . "</sottotitolo>
			<testo>" . trim(str_replace($wrong_string, $right_string, $linea_articoli['testo'])) . "</testo>
		</articolo>";
			}
		
	$xml .= "</sezione>\n";
}

$xml .= "</giornale>\n";

}

$xml .= "</brescia_on_line>";

header('Content-Type: text/xml; charset=utf-8');
echo($xml);
 
?>
