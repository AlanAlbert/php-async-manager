#!/usr/bin/php
<?php
use Async\AsyncManager;

require __DIR__ . '/vendor/autoload.php';

$manager = new AsyncManager();

$manager->run();