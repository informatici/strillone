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

$sUrl = array();

$sUrl['gofasano'] = 'http://gofasano.it/xmlArticoli.php';

$file_xml = file_get_contents($sUrl[$_GET['testata']]);

$wrongs = array();
$rights = array();

$wrongs[] = 'version="1.0"?'; 	$rights[] = 'version="1.0" encoding="UTF-8"?';
$wrongs[] = '&Egrave;'; 		$rights[] = "e";
$wrongs[] = '&nbsp;'; 			$rights[] = ' ';
$wrongs[] = '\r\n\r\n'; 		$rights[] = '\r\n';
$wrongs[] = '&ldquo;'; 			$rights[] = '"';
$wrongs[] = '&rdquo;'; 			$rights[] = '"';
$wrongs[] = '&ugrave;'; 		$rights[] = 'u';
$wrongs[] = '&igrave;'; 		$rights[] = 'i';
$wrongs[] = '&eacute;'; 		$rights[] = 'e';
$wrongs[] = '&agrave;'; 		$rights[] = 'a';
$wrongs[] = '&agrave;'; 		$rights[] = 'a';
$wrongs[] = '&egrave;'; 		$rights[] = 'e';
$wrongs[] = '&rsquo;'; 			$rights[] = '\'';
$wrongs[] = '&ndash;'; 			$rights[] = '-';

$file_xml = str_replace($wrongs,$rights,$file_xml);

header('Content-Type: text/xml; charset=utf-8');
echo $file_xml;
 
?>