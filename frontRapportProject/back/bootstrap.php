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
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$config['rewrite_short_tags'] = FALSE;

$app = new Silex\Application();


/*$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
  "cors.allowOrigin" => "*",
]);*/
$app->register(new Silex\Provider\SessionServiceProvider());

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


$app->get('/connect', function() use($membre,$user,$app){
  $membre->signIn($user);
  $app['session']->set('user',$user);
  return json_encode($user);
});

$app->get('/rapport', function () use($raprepo,$user,$sessions,$app) {
  if($app['session']->get('user')) {
    return json_encode(array("rapports"=>$raprepo->getRapportsbyUser($app['session']->get('user')),"user"=>$app['session']->get('user')));
  }else return json_encode($_SESSION['auth']);
});

$app->get('/deconnect',function() use($membre,$user,$app){
    $membre->signOut($user);
    $app['session']->set('user',null);
    return json_encode($app['session']->get('user'));
});

$app->get('/rapports',function() use($raprepo){
  return json_encode($raprepo->getRapports());
});
//$app["cors-enabled"]($app);

$app->get('/isAuth', function() use($sessions){
  return json_encode($sessions->getUserConnectedByCookies()['login']);
});

$app->run();



?>
