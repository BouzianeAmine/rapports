<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class RapportController extends AbstractFOSRestController
{
    /**
     * @var RapportRepository
     */
    private $rep;
    /**
     * @var EntityManagerInterface
     */
    private $man;

    public function __construct(RapportRepository $rep,EntityManagerInterface $man)
    {
        $this->rep = $rep;
        $this->man = $man;
    }

    public function getRapportsAction()
    {
        return $this->view($this->rep->findAll(),Response::HTTP_OK);
    }

    /**
     * @Rest\RequestParam(name="name",description="nom du rapport")
     * @param ParamFetcher $pf
     * @return View
     */
    public function postRapportAction(ParamFetcher $pf){
        $name= $pf->get('name');
        if($name){
            $rapport=new Rapport();
            $rapport->setName($name);

            $this->man->persist($rapport);
            $this->man->flush();

            return $this->view($rapport,Response::HTTP_CREATED);
        }
        return $this->view("Error",Response::HTTP_BAD_REQUEST);
    }
}
