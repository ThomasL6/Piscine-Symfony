<?php

require_once 'Elem.php';
require_once 'MyException.php';
require_once 'TemplateEngine.php';

try {
	$elem = new Elem('html');
	$body = new Elem('body');
	$body->pushElement(new Elem('p', 'Lorem ipsum', ['class' => 'text-muted']));
	$elem->pushElement($body);
	
	echo $elem->getHTML();
	
	$templateEngine = new TemplateEngine($elem, 'output.html');
	$templateEngine->createFile('output.html');

	$invalid = new Elem('undefined');

} catch (MyException $e) {
	echo "Erreur : " . $e->getMessage() . "\n";
} catch (Exception $e) {
	echo "Erreur : " . $e->getMessage() . "\n";
}

?>
