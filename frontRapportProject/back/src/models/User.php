<?php
namespace src\Models;

class User{
    public $firstname;
    public $lastname;
    public $password;
    public $email;
    public $promotion;
    public $telephone;
    public $naissance;
    public $linkedin;
    public $solde;
    public function __construct($firstname,$lastname,$password,$email,$promotion,$tel,$naissance,$linkedin){

        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->email=$email;
        $this->password=$password;
        $this->promotion=$promotion;
        $this->telephone=$tel;
        $this->naissance=$naissance;
        $this->linkedin=$linkedin;

        if($promotion=="1"){$this->solde=1;}
        else if($promotion=="2"){$this->demandeRapportPormotionUne();}
        else {$this->demandeRapportPormotionUneetdeux();}

    }


    public function  demandeRapportPormotionUne(){
      /*il doit déposer le rapport de la première année */
      $this->solde=2;
    }
    public function demandeRapportPormotionUneetdeux(){$this->demandeRapportPormotionUne();$this->solde++;}

}

?>
