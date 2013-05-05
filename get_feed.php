<?php

/*
 * This file is part of the Strillone package.
 *
 * (c) Informatici Senza Frontiere Onlus <http://informaticisenzafrontiere.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
