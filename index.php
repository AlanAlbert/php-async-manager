#!/usr/bin/php
<?php
use Async\AsyncManager;

require './vendor/autoload.php';

$manager = new AsyncManager();

$manager->run();