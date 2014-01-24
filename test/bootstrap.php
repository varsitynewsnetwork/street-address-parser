<?php

define('PROJECT_ROOT_DIR', realpath(__DIR__ . '/..'));

$autoloader = realpath(PROJECT_ROOT_DIR . '/vendor/autoload.php');

if (!file_exists($autoloader)) {
    throw new \Exception('Dude, you have no vendor!');
}

require_once $autoloader;
