<?php

// Need to trace all kind of errors
ini_set('display_errors', 'On');
error_reporting(E_ALL);

include __DIR__ . '/developer.php';

$loader = require __DIR__ . '/vendor/autoload.php';

use App\Project;

Project::start();
