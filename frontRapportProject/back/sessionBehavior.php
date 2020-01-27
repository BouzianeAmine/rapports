<?php

interface iSessionBehavior {
    public function startSession($membre); //set the membre to true
    public function testCookies($cookie); // test if the cookie is set des isset sur les cookies
    public function testSession($membre); // si la variable $_SESSION is set and equals to true
    public function unsetSession($membre); // pour se deconecter (singout) unset le session variable 
    public function setCookie($user); // après l'inscription creation de la session sessionStart et aussi remplir les cookies
}