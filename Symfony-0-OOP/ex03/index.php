<?php

require_once 'Elem.php';

try {
    echo "=== TEST NORMAL ===\n";
    $elem = new Elem('html');
    $body = new Elem('body');
    $body->pushElement(new Elem('p', 'Lorem ipsum'));
    $elem->pushElement($body);
    
    echo $elem->getHTML();
    echo "\n\n";

	$invalid = new Elem('undefined'); // Cette ligne devrait lever une exception
    
} catch (InvalidArgumentException $e) {
    echo "Exception capturée : " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erreur générale : " . $e->getMessage() . "\n";
}

?>