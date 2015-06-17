<?php

/**
 * This file is simply for use of plugins and themes when core classes are needed without the header etc. of the full bootstrap
 */

require_once 'config.php';

# Fire up the autoloader, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});