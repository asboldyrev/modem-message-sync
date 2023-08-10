<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';
// dd(glob(__DIR__ . '/../../*'));
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
