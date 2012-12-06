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

// all'inizio della pagina
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;


$edizioni = array();

class Edizione {
    public $numero;
    public $sezioni = array();
}

class Sezione {
    public $nome;
    public $articoli;
}

class Articolo {
    public $id;
    public $titolo;
    public $sottotitolo;
    public $testo;
    public $occhiello;

    public function __construct() {
        $this->titolo = strip_tags(html_entity_decode($this->titolo));
        $this->sottotitolo = strip_tags(html_entity_decode($this->sottotitolo));
        $this->testo = strip_tags(html_entity_decode($this->testo));
        $this->occhiello = strip_tags(html_entity_decode($this->occhiello));
    }
}

// Connecting, selecting database
$link = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());

mysql_select_db('rodenic_walks_blindnews') or die('Could not select database');

$query = "select distinct edizione as numero from articoli where edizione='" . $_GET['edizione'] . "';";
$result1 = mysql_query($query) or die('Query failed: ' . mysql_error());

while ($edizione = mysql_fetch_object($result1, 'Edizione')) {
    $query = "select distinct sezione as nome from articoli where edizione='" . $_GET['edizione'] . "';";
    $result2 = mysql_query($query) or die('Query failed: ' . mysql_error());
    
    while ($sezione = mysql_fetch_object($result2, 'Sezione')) {
        $edizione->sezioni[] = $sezione;
        
        $query = "select id_articolo as id, titolo, sottotitolo, testo, occhiello from articoli where edizione='$edizione->numero' and sezione='$sezione->nome';";
        $result3 = mysql_query($query) or die('Query failed: ' . mysql_error());
        
        while ($articolo = mysql_fetch_object($result3, 'Articolo')) {
            $sezione->articoli[] = $articolo;
        }
        
        mysql_free_result($result3);

    }
    $edizioni[] = $edizione;
    
    mysql_free_result($result2);
}

mysql_free_result($result1);

print_r(json_encode($edizioni));

// Closing connection
mysql_close($link);

// alla fine della pagina
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';


?>
