<?php

namespace App\Controller;

use App\Entity\Organisme;
use App\Form\AffectRubType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use App\Entity\Fiche;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */

class RubriqueController extends AbstractController
{
    /**
     * @Route("/rubrique", name="rubrique")
     */
    public function index()
    {
        return $this->render('rubrique/index.html.twig', [
            'controller_name' => 'RubriqueController',
        ]);
    }
    /**
     * @Route("/Supprrub/{id}", name="Rub_supr")
     */
    public function Supprref(Request $request,Rubrique $rubrique): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($rubrique);
        $entityManager->flush();
        return $this->redirectToRoute('Rub_aff');
    }

   /**
     * @Route("/AffRub", name="Rub_aff", methods={"GET"})
     */
    public function aff(RubriqueRepository $rubriqueRepository): Response
    {
        return $this->render('rubrique/editer.html.twig', [
            'rubriques' => $rubriqueRepository->findAll(),
        ]);
    }

   /**
     * @Route("/newRub", name="Rub_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rub = new Rubrique();
        $form = $this->createForm(RubriqueType::class, $rub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rub);
            $entityManager->flush();

            return $this->redirectToRoute('Rub_aff');
        }

        return $this->render('rubrique/new.html.twig', [
            'rubrique' => $rub,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="new_quizz")
     *
    public function newrub(Request $request, ObjectManager $manager)
    {
        $fiche = $this->getFiche();
        $rub = new Rubrique();


        $form = $this->createForm(RubriqueType::class, $rub);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //? j'ajoute le User connecté comme auteur du quizz
            $rub->setFiche($fiche);
            // TODO ajouter un slugger
            #$rub->setSlug('test');
            // TODO comment géer la partie privée si l'utilisateur a plusieurs crew ?
           # dump($user);
            //  $quizz->setCrew('user.crew')
            $manager->persist($rub);
            $manager->flush();
            #dump($request);
        }

        return $this->render('fiche/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
     */
    /**
     * @Route("/{id}",name="affec")
     *
    public function newOrg(Request $request, ObjectManager $manager,Fiche $id)
    {
        $fiche = $id;
        $rub=new Rubrique();

        $form=$this->createForm(RubriqueType::class, $rub);
        $form->handleRequest($request);
        $manager->persist($rub);
        $manager->flush();

        return $this->render('fiche/new.html.twig', [
            'form' => $form->createView()
        ]);
    }*/

    /**
     * @Route("/{id}/editRub", name="Rub_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rubrique $rubrique): Response
    {
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Rub_aff');
        }

        return $this->render('rubrique/edit.html.twig', [
            'rubrique' => $rubrique,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/affectationR/{id_organisme}", name="affeco")//2
     */
    public function newOrg(Request $request, $id_organisme):Response
//    public function newOrg(Request $request,Rubrique $id,Organisme $organisme,OrganismeRepository $organismeRepository):Response
    {
        $form = $this->createForm(AffectRubType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $organisme=$this->getDoctrine()->getRepository(Organisme::class)->findOneBy(['id' => $id_organisme]);
            //dump($request);die();
            $id_rubrique=$request->request->get('affect_rub');
            $id_rubriques=$id_rubrique['rubrique'];
            //dump($id_rubrique2);die();
            foreach($id_rubriques as $id_rubrique){
                $rubrique2 = $this->getDoctrine()->getRepository(Rubrique::class)->findOneBy(['id' => $id_rubrique]);
                //$rubrique2 = $this->getDoctrine()->getRepository(Rubrique::class)->findOneBy(['id' => 13]);

//dump($rubrique2);die();
                $organisme->addRubrique($rubrique2);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisme);
            $entityManager->flush();

            return $this->redirectToRoute('orga_aff');
        }
        return $this->render('organisme/edit.html.twig', ['form' => $form->createView()]);
    }
}
