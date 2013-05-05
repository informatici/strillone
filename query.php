<?php

/*
 * This file is part of the Strillone package.
 *
 * (c) Informatici Senza Frontiere Onlus <http://informaticisenzafrontiere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

include 'config.php';

if (is_numeric($_GET['edizione'])) {
    $edizione = substr($_GET['edizione'],0,4) . "-" . substr($_GET['edizione'],4,2) . "-" . substr($_GET['edizione'],6,2);
    $wrong_string = array("%","<TAB>","<i>","<I>","</i>","</I>","<b>","<B>","</b>","</B>","<br>","<BR>","<BR />","<BR/>","&nbsp;","&#146;","&#171;","&#187;","&");
    $right_string = array(" %","","","","","","","","",""," "," "," "," "," ","'","'","'","e");

    $xml = "<?xml version='1.0' encoding='UTF-8'?>
        <giornale>
        <lingua>it</lingua>
        <testata>Brescia on line</testata>
        <edizione>" . $edizione . "</edizione>";

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
                $xml .= "			</sezione>";
            }

            $xml .= "\n			<sezione>
                <nome>Sezione " . $i . ": " . $linea['sezione'] . "</nome>";

        }

        $j++;
        $xml .= "
            <articolo>
            <titolo><![CDATA[Articolo " . $j . ": " . trim(str_replace($wrong_string, $right_string, $linea['occhiello'])) . " " . trim(str_replace($wrong_string, $right_string, $linea['titolo'])) . " " . trim(str_replace($wrong_string, $right_string, $linea['sottotitolo'])) . "]]></titolo>
            <testo><![CDATA[" . trim(str_replace($wrong_string, $right_string, $linea['testo'])) . "]]></testo>
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
