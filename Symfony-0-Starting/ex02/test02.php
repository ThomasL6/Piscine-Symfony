<?php
include('./array2hash.php');
$array = array(array("Pierre","30"), array("Mary","28"));
print_r ( array2hash($array) );
// Affiche le résultat : Array ( [30] => Pierre [28] => Mary )