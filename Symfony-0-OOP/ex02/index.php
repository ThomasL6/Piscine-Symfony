<?php

require_once 'TemplateEngine.php';
require_once 'HotBeverage.php';
require_once 'Coffee.php';
require_once 'Tea.php';

$beverages = [
	new Coffee(),
	new Tea(),
];

$templateEngine = new TemplateEngine('template.html', [
	'title' => 'Hot Beverages',
	'date' => date('Y-m-d')
]);

foreach ($beverages as $beverage)
{
	$templateEngine->createFile($beverage, $beverage);
}
?>
