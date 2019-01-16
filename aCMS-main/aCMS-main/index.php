<?php

set_time_limit(30);

// check PHP platform requirements
if (PHP_VERSION_ID < 50306) {
    die('aCMS requires PHP 5.3.6 or above to run');
}
if (!extension_loaded('dom')) {
    die('aCMS requires the PHP extension "dom" to run');
}
if (!extension_loaded('mbstring')) {
    die('aCMS requires the PHP extension "mbstring" to run');
}

// load dependencies
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/scripts/PHP/_autoload.php');

// Log visitor.
LogVisit();

// Build page
require('scripts/PHP/view_handler.php');

