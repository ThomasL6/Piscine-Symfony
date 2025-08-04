<?php

require_once 'Elem.php';
require_once 'MyException.php';
require_once 'TemplateEngine.php';

try {
	// Test de base avec génération de fichier
	echo "=== TEST DE BASE ===\n";
	$elem = new Elem('html');
	$body = new Elem('body');
	$body->pushElement(new Elem('p', 'Lorem ipsum', ['class' => 'text-muted']));
	$elem->pushElement($body);
	
	echo $elem->getHTML();
	echo "\n";
	
	$templateEngine = new TemplateEngine($elem, 'output.html');
	$templateEngine->createFile('output.html');

	// Test d'exception avec balise invalide
	echo "\n=== TEST EXCEPTION ===\n";
	try {
		$invalid = new Elem('undefined');
	} catch (MyException $e) {
		echo "✓ Exception capturée pour balise invalide : " . $e->getMessage() . "\n";
	}

	// Tests de validation validPage()
	echo "\n=== TESTS VALIDPAGE ===\n";
	
	// Test 1: Structure HTML valide complète
	echo "\nTest 1: Structure HTML valide complète\n";
	$html1 = new Elem('html');
	$head1 = new Elem('head');
	$title1 = new Elem('title', 'Mon titre');
	$meta1 = new Elem('meta', '', ['charset' => 'UTF-8']);
	$body1 = new Elem('body');
	$p1 = new Elem('p', 'Paragraphe avec du texte seulement');
	
	$head1->pushElement($title1);
	$head1->pushElement($meta1);
	$body1->pushElement($p1);
	$html1->pushElement($head1);
	$html1->pushElement($body1);
	
	if ($html1->validPage()) {
		echo "✓ PASS: Structure HTML complète valide\n";
	} else {
		echo "✗ FAIL: Structure HTML complète invalide\n";
	}
	
	// Test 2: Élément racine non-html
	echo "\nTest 2: Élément racine n'est pas html\n";
	$div2 = new Elem('div');
	$head2 = new Elem('head');
	$body2 = new Elem('body');
	
	$div2->pushElement($head2);
	$div2->pushElement($body2);
	
	if (!$div2->validPage()) {
		echo "✓ PASS: Élément racine non-html détecté\n";
	} else {
		echo "✗ FAIL: Élément racine non-html non détecté\n";
	}
	
	// Test 3: Plusieurs title dans head
	echo "\nTest 3: Plusieurs title dans head\n";
	$html3 = new Elem('html');
	$head3 = new Elem('head');
	$title3a = new Elem('title', 'Titre 1');
	$title3b = new Elem('title', 'Titre 2');
	$body3 = new Elem('body');
	
	$head3->pushElement($title3a);
	$head3->pushElement($title3b);
	$html3->pushElement($head3);
	$html3->pushElement($body3);
	
	if (!$html3->validPage()) {
		echo "✓ PASS: Plusieurs title détectés\n";
	} else {
		echo "✗ FAIL: Plusieurs title non détectés\n";
	}
	
	// Test 4: Plusieurs meta charset dans head
	echo "\nTest 4: Plusieurs meta charset dans head\n";
	$html4 = new Elem('html');
	$head4 = new Elem('head');
	$meta4a = new Elem('meta', '', ['charset' => 'UTF-8']);
	$meta4b = new Elem('meta', '', ['charset' => 'ISO-8859-1']);
	$body4 = new Elem('body');
	
	$head4->pushElement($meta4a);
	$head4->pushElement($meta4b);
	$html4->pushElement($head4);
	$html4->pushElement($body4);
	
	if (!$html4->validPage()) {
		echo "✓ PASS: Plusieurs meta charset détectés\n";
	} else {
		echo "✗ FAIL: Plusieurs meta charset non détectés\n";
	}
	
	// Test 5: P avec élément HTML (invalide)
	echo "\nTest 5: P avec élément HTML (invalide)\n";
	$html5 = new Elem('html');
	$head5 = new Elem('head');
	$body5 = new Elem('body');
	$p5 = new Elem('p', 'Texte avec ');
	$span5 = new Elem('span', 'span');
	$p5->pushElement($span5);
	
	$body5->pushElement($p5);
	$html5->pushElement($head5);
	$html5->pushElement($body5);
	
	if (!$html5->validPage()) {
		echo "✓ PASS: P avec élément HTML détecté\n";
	} else {
		echo "✗ FAIL: P avec élément HTML non détecté\n";
	}
	
	// Test 6: Table valide avec tr/th/td
	echo "\nTest 6: Table valide avec tr/th/td\n";
	$html6 = new Elem('html');
	$head6 = new Elem('head');
	$body6 = new Elem('body');
	$table6 = new Elem('table');
	$tr6 = new Elem('tr');
	$th6 = new Elem('th', 'Header');
	$td6 = new Elem('td', 'Data');
	
	$tr6->pushElement($th6);
	$tr6->pushElement($td6);
	$table6->pushElement($tr6);
	$body6->pushElement($table6);
	$html6->pushElement($head6);
	$html6->pushElement($body6);
	
	if ($html6->validPage()) {
		echo "✓ PASS: Table valide détectée\n";
	} else {
		echo "✗ FAIL: Table valide non détectée\n";
	}
	
	// Test 7: Table avec élément invalide
	echo "\nTest 7: Table avec élément invalide\n";
	$html7 = new Elem('html');
	$head7 = new Elem('head');
	$body7 = new Elem('body');
	$table7 = new Elem('table');
	$div7 = new Elem('div', 'Invalid in table');
	
	$table7->pushElement($div7);
	$body7->pushElement($table7);
	$html7->pushElement($head7);
	$html7->pushElement($body7);
	
	if (!$html7->validPage()) {
		echo "✓ PASS: Table avec élément invalide détectée\n";
	} else {
		echo "✗ FAIL: Table avec élément invalide non détectée\n";
	}
	
	// Test 8: UL valide avec li
	echo "\nTest 8: UL valide avec li\n";
	$html8 = new Elem('html');
	$head8 = new Elem('head');
	$body8 = new Elem('body');
	$ul8 = new Elem('ul');
	$li8a = new Elem('li', 'Item 1');
	$li8b = new Elem('li', 'Item 2');
	
	$ul8->pushElement($li8a);
	$ul8->pushElement($li8b);
	$body8->pushElement($ul8);
	$html8->pushElement($head8);
	$html8->pushElement($body8);
	
	if ($html8->validPage()) {
		echo "✓ PASS: UL valide détectée\n";
	} else {
		echo "✗ FAIL: UL valide non détectée\n";
	}
	
	// Test 9: OL valide avec li
	echo "\nTest 9: OL valide avec li\n";
	$html9 = new Elem('html');
	$head9 = new Elem('head');
	$body9 = new Elem('body');
	$ol9 = new Elem('ol');
	$li9a = new Elem('li', 'Premier item');
	$li9b = new Elem('li', 'Deuxième item');
	
	$ol9->pushElement($li9a);
	$ol9->pushElement($li9b);
	$body9->pushElement($ol9);
	$html9->pushElement($head9);
	$html9->pushElement($body9);
	
	if ($html9->validPage()) {
		echo "✓ PASS: OL valide détectée\n";
	} else {
		echo "✗ FAIL: OL valide non détectée\n";
	}
	
	// Test 10: UL avec élément invalide
	echo "\nTest 10: UL avec élément invalide\n";
	$html10 = new Elem('html');
	$head10 = new Elem('head');
	$body10 = new Elem('body');
	$ul10 = new Elem('ul');
	$p10 = new Elem('p', 'Invalid in ul');
	
	$ul10->pushElement($p10);
	$body10->pushElement($ul10);
	$html10->pushElement($head10);
	$html10->pushElement($body10);
	
	if (!$html10->validPage()) {
		echo "✓ PASS: UL avec élément invalide détectée\n";
	} else {
		echo "✗ FAIL: UL avec élément invalide non détectée\n";
	}
	
	// Test 11: TR avec élément invalide
	echo "\nTest 11: TR avec élément invalide\n";
	$html11 = new Elem('html');
	$head11 = new Elem('head');
	$body11 = new Elem('body');
	$table11 = new Elem('table');
	$tr11 = new Elem('tr');
	$span11 = new Elem('span', 'Invalid in tr');
	
	$tr11->pushElement($span11);
	$table11->pushElement($tr11);
	$body11->pushElement($table11);
	$html11->pushElement($head11);
	$html11->pushElement($body11);
	
	if (!$html11->validPage()) {
		echo "✓ PASS: TR avec élément invalide détecté\n";
	} else {
		echo "✗ FAIL: TR avec élément invalide non détecté\n";
	}

	// Test 12: Structure complexe mais valide
	echo "\nTest 12: Structure complexe mais valide\n";
	$html12 = new Elem('html');
	$head12 = new Elem('head');
	$title12 = new Elem('title', 'Page complexe');
	$meta12 = new Elem('meta', '', ['charset' => 'UTF-8']);
	$body12 = new Elem('body');
	
	// Div avec paragraphe
	$div12 = new Elem('div');
	$p12 = new Elem('p', 'Texte dans un paragraphe');
	$div12->pushElement($p12);
	
	// Table
	$table12 = new Elem('table');
	$tr12 = new Elem('tr');
	$th12 = new Elem('th', 'Colonne 1');
	$td12 = new Elem('td', 'Donnée 1');
	$tr12->pushElement($th12);
	$tr12->pushElement($td12);
	$table12->pushElement($tr12);
	
	// Liste
	$ul12 = new Elem('ul');
	$li12 = new Elem('li', 'Item de liste');
	$ul12->pushElement($li12);
	
	$head12->pushElement($title12);
	$head12->pushElement($meta12);
	$body12->pushElement($div12);
	$body12->pushElement($table12);
	$body12->pushElement($ul12);
	$html12->pushElement($head12);
	$html12->pushElement($body12);
	
	if ($html12->validPage()) {
		echo "✓ PASS: Structure complexe valide détectée\n";
	} else {
		echo "✗ FAIL: Structure complexe valide non détectée\n";
	}

	echo "\n=== TOUS LES TESTS TERMINÉS ===\n";

} catch (MyException $e) {
	echo "Erreur MyException : " . $e->getMessage() . "\n";
} catch (Exception $e) {
	echo "Erreur Exception : " . $e->getMessage() . "\n";
}

?>
