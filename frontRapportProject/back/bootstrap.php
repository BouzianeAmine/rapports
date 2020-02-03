<?php

require 'vendor/autoload.php';
error_reporting(0);

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
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With");

$config['rewrite_short_tags'] = FALSE;

$app = new Silex\Application();



$app->register(new Silex\Provider\SessionServiceProvider());

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$con=new Connector();
$repo=new UserRepository($con);
$raprepo=new RapportRepository($con);
//$user=new User("amine","bouziane","12345678","aminebouz84@gmail.com","1","0769205922","08/09/1995","http://kfhkksssf.com");
$sessions=new SessionFactory($app);
$membre=new Membre($repo,$sessions,$raprepo);
$rapport=new Rapport("rapport","pdf","zfjkzkefkzegfkzhegfe");

$app->post('/connect', function(Request $req) use($membre,$repo){
  //var_dump(json_decode($req->getContent(),true));
  $current_user=$repo->getUserByemail(json_decode($req->getContent(),true)['email']);
  if($membre->signIn($current_user)) { return json_encode($current_user);}
  else return json_encode(false);
});

$app->get('/rapport', function () use($raprepo,$sessions,$repo) {
  if($sessions->testSession()) {
    return json_encode($raprepo->getRapportsbyUser($repo->getUserByemail($sessions->getUserConnectedByCookies())));
  }else return json_encode($sessions->app['session']->get('auth'));
});

$app->get('/deconnect',function() use($membre,$repo,$sessions){
    //var_dump($repo->getUserByemail($sessions->getUserConnectedByCookies()));
    if($membre->signOut($repo->getUserByemail($sessions->getUserConnectedByCookies())))
      return json_encode(true);
    else return json_encode(false);
});

$app->get('/rapports',function() use($raprepo){
  return json_encode($raprepo->getRapports());
});


$app->get('/isAuth', function() use($app){
  return  json_encode($app['session']->get('auth'));
});


//$app["cors-enabled"]($app);
$app->run();



?>
