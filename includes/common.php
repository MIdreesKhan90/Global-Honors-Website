<?php
declare(strict_types=1);
if (@!include __DIR__ . '/../vendor/autoload.php') {
    echo 'Install Latte using `composer install`';
    exit(1);
}
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

include_once 'WebsiteApiModule.php';

use Latte\Engine;

$latte = new Engine;

// cache directory
// Set the temporary directory for compiled templates
$latte->setTempDirectory(__DIR__ . '/../temp');
