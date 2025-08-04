<?php

require_once 'Elem.php';

require_once 'Elem.php';
require_once 'TemplateEngine.php';

$html = new Elem('html');
$body = new Elem('body');
$h1 = new Elem('h1', 'Hello');
$p = new Elem('p', 'Lorem ipsum');

$body->pushElement($h1);
$body->pushElement($p);
$html->pushElement($body);

// Crée le moteur de template avec ton arbre Elem
$template = new TemplateEngine($html, 'template.html');
$template->createFile('output.html');


?>
