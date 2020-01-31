<?php

namespace src\Models;

class Rapport{

    public $name;
    public $type;
    public $data;
    public $email;

    public function __construct(string $name,string $type,string $data)
    {
        $this->name=$name;
        $this->data=$data;
        $this->type=$type;
    }

    
    
}