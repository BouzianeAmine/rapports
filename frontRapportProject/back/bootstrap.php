<?php

require 'vendor/autoload.php';
error_reporting(E_ALL ^ E_WARNING);

include('./src/system/Connector.php');
include('./src/models/User.php');
include('./src/repos/userRepo.php');
include('./src/Membre.php');
include('./src/session/SessionsFactroy.php');
include('./src/repos/rapportRepo.php');
include('./src/models/Rapport.php');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dotenv\Dotenv;
use src\factory\SessionFactory;
use src\Models\Rapport;
use src\System\Connector;
use src\Models\User;
use src\Repositories\RapportRepository;
use src\Repositories\UserRepository;
use src\User\Membre;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, DELETE');
header('Content-Type: application/json');

$config['rewrite_short_tags'] = FALSE;

$app = new Silex\Application();


/*$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
  "cors.allowOrigin" => "*",
]);*/

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

//var_dump(getenv('DB_DATABASE'));

$con=new Connector();
$repo=new UserRepository($con);
$raprepo=new RapportRepository($con);
$user=new User("amine","bouziane","12345678","aminebouz84@gmail.com","1","0769205922","08/09/1995","http://kfhkksssf.com");
//$count=$repo->addUser($user); adding the user to database
//$res=$repo->deleteUser($user); deleting a user from the database
$sessions=new SessionFactory();
$membre=new Membre($repo,$sessions,$raprepo);

//$membre->signIn($user);
$rapport=new Rapport("rapport","pdf","zfjkzkefkzegfkzhegfe");
//var_dump($rapport);
//$membre->addRapport($rapport);
//var_dump($raprepo->getRapportsbyUser($user));
//var_dump($_SESSION['auth']); //signin is done nicelyyyyy hamdollah
//var_dump($rapport);

//$membre->signOut($user);
//var_dump($_SESSION['auth']);//signout done



$app->get('/rapport', function () use($raprepo,$user,$sessions) {
  if($sessions->testSession()) {
    return json_encode($raprepo->getRapportsbyUser($user));
  }else return json_encode($_SESSION['auth']);
});

$app->get('/connect', function() use($membre,$user){
    $membre->signIn($user);
    return json_encode($_SESSION['auth']);
});

$app->get('/deconnect',function() use($membre,$user){
    $membre->signOut($user);
    return json_encode($_SESSION['auth']);
});
//$app["cors-enabled"]($app);
$app->run();


?>
