<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rubrique;
use App\Entity\Organisme;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use App\Entity\Fiche;
use Symfony\Component\HttpFoundation\Response;
use App\Form\Affect;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /*
     * @Route("/affectation",name="affc")
     *
    public function newOrg()//:Response
    {

        //$form = $this->createForm(Affect::class);
        //$form->handleRequest($request);


        //if ($form->isSubmitted() && $form->isValid()) {

        $rubrique = 1;
        $rub = new Rubrique();


        //dump($organisme);dump($rub);die();
        //$rub->addRubrique(Rubrique $rubrique);
        $this->rubrique->add($rubrique);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($rub);
        $entityManager->flush();


        return $this->redirectToRoute('Rub_aff');

    //}
        //return $this->render('rubrique/edit.html.twig', ['form' => $form->createView()]);
    }
    */
}
