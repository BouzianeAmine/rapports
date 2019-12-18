<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class RapportController extends AbstractFOSRestController
{
   
    public function getRapportsAction()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RapportController.php',
        ]);
    }

    public function getUserRapportsAction(int $id)
    {
        # code...
    }
}
