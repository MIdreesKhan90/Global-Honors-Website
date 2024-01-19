<?php

declare(strict_types=1);

if (@!include __DIR__ . '/vendor/autoload.php') {
	echo 'Install Latte using `composer install`';
	exit(1);
}

$latte = new Latte\Engine;
// cache directory
// Set the temporary directory for compiled templates
$latte->setTempDirectory(__DIR__ . '/temp');

$params = [ /* template variables */ ];
// or $params = new TemplateParameters(/* ... */);

// render to output
$latte->render('templates/privacy-policy.latte', $params);