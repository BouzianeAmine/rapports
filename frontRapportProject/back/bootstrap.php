<?php

require 'vendor/autoload.php';

include('./src/system/Connector.php');
include('./src/models/User.php');
include('./src/repos/userRepo.php');
include('./src/Membre.php');
include('./src/session/SessionsFactroy.php');
include('./src/repos/rapportRepo.php');
include('./src/models/Rapport.php');

use Dotenv\Dotenv;
use src\factory\SessionFactory;
use src\Models\Rapport;
use src\System\Connector;
use src\Models\User;
use src\Repositories\RapportRepository;
use src\Repositories\UserRepository;
use src\User\Membre;


$app = new Silex\Application();

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

var_dump(getenv('DB_DATABASE'));

$con=new Connector();
$repo=new UserRepository($con);
$raprepo=new RapportRepository($con);
$user=new User("amine","bouziane","12345678","aminebouz84@gmail.com","1","0769205922","08/09/1995","http://kfhkksssf.com");
//$count=$repo->addUser($user); adding the user to database
//$res=$repo->deleteUser($user); deleting a user from the database
$membre=new Membre($repo,new SessionFactory(),$raprepo);

$membre->signIn($user);
$rapport=new Rapport("rapport","pdf","zfjkzkefkzegfkzhegfe");
//var_dump($rapport);
//$membre->addRapport($rapport);
var_dump($raprepo->getRapportsbyUser($user));
var_dump($_SESSION['auth']); //signin is done nicelyyyyy hamdollah
//var_dump($rapport);

$membre->signOut($user);
var_dump($_SESSION['auth']);//signout done

$app = new Silex\Application();


$app->get('/contact', function () {
    $rapport=new Rapport("rapport","pdf","zfjkzkefkzegfkzhegfe");
    return json_encode($rapport);
});
$app->run();
?>
