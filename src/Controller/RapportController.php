<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Rest\Get(path="rapports",name="get_all_rapports")
     * @return View
     */
    public function getRapportsAction()
    {
        return $this->view($this->rep->findAll(),Response::HTTP_OK);
    }

    /**
     * @Rest\Post("api/rapport",name="post_rapport")
     * @ParamConverter("rapport",converter="fos_rest.request_body") //celui c'est lui qui dis comme quoi convertir le request on objet
     * @param Rapport $rapport
     * @return View
     */
    public function postRapport(Rapport $rapport){
        $this->man->persist($rapport);
        $this->man->flush();
        return $this->view($rapport,Response::HTTP_CREATED);
    }
}
