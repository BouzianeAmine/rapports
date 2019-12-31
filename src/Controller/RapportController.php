<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Repository\RapportRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
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

    public function getRapportsAction()
    {
        return $this->view($this->rep->findAll(),Response::HTTP_OK);
    }

    /**
     * @Rest\Post("api/rapport",name="post_rapport")
     *
     * @param Request $request
     * @return View
     */
    public function postRapport(Request $request){
        $data= json_decode($request->getContent(),true);
        $name= $data['name'];
        $type= $data['type'];
        $blob= $data['blob'];
        $rapport=new Rapport();
        if($name){

            $rapport->setName($name);
            $rapport->setType($type);
            $rapport->setData($blob);
            $this->man->persist($rapport);
            $this->man->flush();
            return $this->json($data);
        }

        return $this->view($data['blob'],Response::HTTP_CREATED);
       // return $this->view("message error",Response::HTTP_BAD_REQUEST);
    }
}
