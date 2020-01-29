<?php

namespace src\Behaviors;

interface iUserBehavior {
    public function signUp($user);
    public function signIn($user);
    public function signOut($user);
}


?>