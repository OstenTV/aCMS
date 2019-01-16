<?php

// Scan autoload/ dir for stuff.
$dependencies = scandir(__DIR__ . '/autoload/');

// Require everything.
foreach ($dependencies as $dependency)
{
    if ($dependency != '.' && $dependency != '..') {
        require(__DIR__ . '/autoload/' . $dependency);
    }
}

?>