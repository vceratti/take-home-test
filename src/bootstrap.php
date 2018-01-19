<?php

declare(strict_types = 1);

set_error_handler(function ($errno, $errstr, $errfile) {
    throw new \Exception("$errno  $errstr  $errfile");
});

require_once __DIR__ . '/../vendor/autoload.php';
