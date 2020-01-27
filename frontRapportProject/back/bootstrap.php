<?php

require 'vendor/autoload.php';
use Dotenv\Dotenv;
use src\System\Connector;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

echo getenv('OKTA--TEST');

$connection=(new Connector())->getConnection();

var_dump($connection);