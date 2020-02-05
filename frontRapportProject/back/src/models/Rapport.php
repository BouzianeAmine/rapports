<?php

namespace src\Models;

use http\Env\Request;

class Rapport{

    public $name;
    public $type;
    public $data;
    public $email;

    public function __construct(string $name,string $type,string $data,string $email)
    {
        $this->name=$name;
        $this->data=$data;
        $this->type=$type;
        $this->email=$email;
    }

    public static function rapportFromArray($rapport){
      return new Rapport($rapport['name'],$rapport['type'],$rapport['data'],$rapport['email']);
    }


}
