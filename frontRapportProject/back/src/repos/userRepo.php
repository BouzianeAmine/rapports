<?php

namespace src\Repositories;

include('../models/User.php');
include('../system/Connector.php');

use PDO;
use src\Models\User;
use src\System\Connector;

class UserRepository {

    private $connector;

    public function __construct(Connector $connector)
    {
        $this->connector=$connector->getConnection();
    }

    public function addUser(User $user)
    {
        if($this->checkUser($user)){
            return false;
        }
        $stat='Insert Into user (firstname,lastname,password,email,promotion,telephone,naissance,linkedin,solde) values (:firstname,:lastname,:password,:email,:promotion,:telephone,:naissance,:linkedin,:solde)';
        $prep=$this->connector->prepare($stat);
        return $prep->execute(array(':firstname'=>$user->firstname,':lastname'=>$user->lastname,':password'=>$user->password,'email'=>$user->email,'promotion'=>$user->promotion,':telephone'=>$user->telephone,'naissance'=>$user->naissance,'linkedin'=>$user->linkedin,'solde'=>$user->solde));

    }

    public function updateUser(User $user){
        $stat='update table user set firstname=:firstname,lastname=:lastname,password=:password,email=:email,promotion=:promotion,telephone=:telephone,naissance=:naissance,linkedin=:linkedin,solde=:solde';
        $prep=$this->connector->prepare($stat);
        return $prep->execute(array(':firstname'=>$user->firstname,':lastname'=>$user->lastname,':password'=>$user->password,'email'=>$user->email,'promotion'=>$user->promotion,':telephone'=>$user->telephone,'naissance'=>$user->naissance,'linkedin'=>$user->linkedin,'solde'=>$user->solde));
    }

    public function deleteUser(User $user){
        $stat='delete from user where email=:email';
        $prep=$this->connector->prepare($stat);
        return $prep->execute(array(':email'=>$user->email));
    }

    public function checkUser(User $user){
        $stat='select * from user where email=:email';
        $prep=$this->connector->prepare($stat);
        $prep->execute(array(':email'=>$user->email));
        if($prep->rowCount()>0){
            return true;
        }else return false;
    }

    public function getUserByemail(string $email){
        $stat='select * from user where email=:email';
        $prep=$this->connector->prepare($stat);
        $prep->execute(array(':email'=>$email));
        return User::userFromArray($prep->fetchAll(PDO::FETCH_ASSOC)[0]);
    }

}
?>
