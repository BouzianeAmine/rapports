<?php
require 'vendor/autoload.php';
include('./src/system/Connector.php');
use Dotenv\Dotenv;
use src\System\Connector;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

var_dump(getenv('DB_USERNAME'));

$connection=(new Connector())->getConnection();

var_dump($connection->query("Select * from rapport")->fetchObject());
?>