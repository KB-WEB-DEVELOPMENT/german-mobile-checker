<?php

require __DIR__ . '/../vendor/autoload.php';

use Kbarut\Telecommunication\MobileChecker;

$mobileChecker = new MobileChecker();

var_dump($mobileChecker->validate('015203917791')); // bool(true)
