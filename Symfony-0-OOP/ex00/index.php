<?php
require_once 'TemplateEngine.php';

$parameters = [
	"nom" => "1984",
	"auteur" => "George Orwell",
	"description" => "Un roman dystopique puissant et visionnaire.",
	"prix" => "9.99",
];

$template = new TemplateEngine('output.html', 'book_description.html', $parameters);
$template->createFile($template->fileName, $template->templateName, $template->parameters);