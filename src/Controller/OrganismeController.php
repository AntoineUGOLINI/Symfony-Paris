<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\User;
use App\Form\FicheType;
use App\Form\OrganismeType;
use App\Repository\FicheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Organisme;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\OrganismeRepository;
use App\Repository\RubriqueRepository;
use App\Repository\UserRepository;
use App\Form\Affect;
use App\Entity\Rubrique;
use Spipu\Html2Pdf\Html2Pdf;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class OrganismeController extends AbstractController
{
    /**
     * @Route("/index organisme", name="organisme")
     */
    public function index()
    {
        return $this->render('organisme/index.html.twig', [
            'controller_name' => 'OrganismeController',
        ]);
    }

    /**
     * @Route("/Supprorga/{id}", name="Org_supr")
     */
    public function SupprOrga(Organisme $organisme,Request $request): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($organisme);
        $entityManager->flush();
        return $this->redirectToRoute('orga_aff');

    }

    /**
     * @Route("/AffOrga", name="orga_aff", methods={"GET"})
     */
    public function aff(OrganismeRepository $organismeRepository): Response
    {
        return $this->render('organisme/editer.html.twig', [
            'organismes' => $organismeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newOrga", name="orga_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        //dump($request);die();

        $organisme = new organisme();
        $organisme->setCreaAuto(new \DateTime('now'));
        //$user = new User();
        /*$repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App\Entity\Repository');
        $user = $repository->findBy(user);

        //$user $repository->find(14);
        $organisme->setUser($user);*/
        $form = $this->createForm(organismeType::class, $organisme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisme);
            $entityManager->flush();

            return $this->redirectToRoute('orga_aff');
        }

        return $this->render('organisme/new.html.twig', [
            'organisme' => $organisme,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/affectationO/{id_rubrique}", name="affec")//1
     */
    public function newOrg(Request $request, $id_rubrique):Response
//    public function newOrg(Request $request,Rubrique $id,Organisme $organisme,OrganismeRepository $organismeRepository):Response
    {

        $form = $this->createForm(Affect::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rubrique=$this->getDoctrine()->getRepository(Rubrique::class)->findOneBy(['id' => $id_rubrique]);
            $id_organisme=$request->request->get('affect');
            $id_organismes=$id_organisme['organisme'];
            foreach($id_organismes as $id_organisme2) {
                $organisme2 = $this->getDoctrine()->getRepository(Organisme::class)->findOneBy(['id' => $id_organisme2]);
                $rubrique->addOrganisme($organisme2);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rubrique);
            $entityManager->flush();

        return $this->redirectToRoute('Rub_aff');
    }

        return $this->render('rubrique/edit.html.twig', ['form' => $form->createView()]);
    }

         /**
         * @Route("/affectation2/{id_rubrique}", name="affect")
         */
        public function addOrg(Request $request,ObjectManager $manager,int $id) {
            $organisme = $manager->getRepository(Organisme::class)->find($id);
            $form = $this->createForm(Affect::class, $organisme);
            $form->handleRequest($request);

            if ($form->isSubmitted()){
                $manager->persist($organisme);
                $manager->flush();
                return $this->redirectToRoute('Rub_aff');
            }

            return $this->render(
                'rubrique/edit.html.twig',
                array('form' => $form->createView())
            );
        }
        /**
         * @Route("/{id}/editorg", name="orga_edit", methods={"GET","POST"})
         */
    public function edit(Request $request, Organisme $organisme): Response
    {
        $organisme->setModifAuto(new \DateTime('now'));
        $form = $this->createForm(OrganismeType::class, $organisme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orga_aff');
        }

        return $this->render('organisme/edit.html.twig', [
            'oragnismes' => $organisme,
            'form' => $form->createView(),
        ]);
    }
    /*public function createAction(Request $request)
    {
        $article = new article();
        $article->setDate(new \DateTime('now'));

        $form = $this->createFormBuilder($article)
            ->add('Titre', 'text')
            ->add('Texte', 'textarea')
            ->add('submit', 'submit',  array('label' => 'Envoyer'))
            ->getForm();

        $form->handleRequest($request);

        if($request->isMethod('post') && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();
        }

        return $this->render('JRBlogBundle:article:create.html.twig', array('form' => $form->createView()));
    }*/
}
