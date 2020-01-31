<?php

namespace src\factory;

include('../models/User.php');

use src\Models\User;

interface iSessionBehavior {
    public function startSession(); //set the membre to true
    public function testCookies(); // test if the cookie is set des isset sur les cookies
    public function testSession(); // si la variable $_SESSION is set and equals to true
    public function unsetSession(); // pour se deconecter (singout) unset le session variable 
    public function setCookie(User $membre); // après l'inscription creation de la session sessionStart et aussi remplir les cookies
}

class SessionFactory implements iSessionBehavior
{

    public function __construct(){}

    public function startSession(){
        if($this->testSession()){return true;}
        session_start();
        $_SESSION['auth'] = true;
        return true;
    }
    public function testCookies(){
        if(isset($_COOKIE['membre']['login']) && isset($_COOKIE['membre']['mdp'])){
            return true;
        }else return false;
    } // test if the cookie is set des isset sur les cookies, leave it for the checking factory
    public function testSession(){
        if(isset($_SESSION['auth']) && $_SESSION['auth']==true){
            return true;
        }else return false;
    } // si la variable $_SESSION is set and equals to true leave it for the sessioncheking factory 
    public function unsetSession(){
        unset($_SESSION['auth']);
        session_destroy();
    } // pour se deconecter (singout) unset le session variable 
    public function setCookie(User $membre){
        if($this->testCookies()){return true;}
        setcookie("membre[login]",$membre->email, time() + 3600*24*365); 
        setcookie("membre[mdp]", md5($membre->password), time() + 3600*24*365);
    } // après l'inscription creation de la session sessionStart et aussi remplir les cookies don't need to unset them after a year they will unset them selfes
    
}