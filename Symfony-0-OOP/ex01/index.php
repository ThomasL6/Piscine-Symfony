<?php

require_once 'Text.php';
require_once 'TemplateEngine.php';

$text = new Text([
	"Ligne 1",
	"Ligne 2"
]);

$text->append("Ligne 3");
$text->append("Ligne 4");

$template = new TemplateEngine("template.html", [
	"title" => "Mon document généré"
]);

$template->createFile("output.html", $text);

?>
