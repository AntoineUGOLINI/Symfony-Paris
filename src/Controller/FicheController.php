<?php

namespace App\Controller;

use App\Entity\Fiche;
use App\Entity\Organisme;
use App\Form\FicheType;
use App\Entity\User;
use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\FicheRepository;
use App\Repository\OrganismeRepository;
use App\Repository\RubriqueRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Spipu\Html2Pdf\Html2Pdf;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */

class FicheController extends AbstractController
{
    /**
     * @Route("/fiche", name="fiche")
     */
    public function index()
    {
        return $this->render('fiche/index.html.twig', [
            'controller_name' => 'FicheController',
        ]);
    }

    /**
     * @Route("/Supprfiche/{id}", name="fiche_supr")
     */
    public function Supprref(Request $request,Fiche $fiche): Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->remove($fiche);
        $entityManager->flush();
        return $this->redirectToRoute('fiche_aff');
    }

    /**
     * @Route("/AffFiche", name="fiche_aff", methods={"GET"})
     */
    public function aff(ficheRepository $ficheRepository): Response
    {
        return $this->render('fiche/editer.html.twig', [
            'fiches' => $ficheRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newF", name="fiche_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fiche = new fiche();
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fiche);
            $entityManager->flush();

            return $this->redirectToRoute('fiche_aff');
        }

        return $this->render('fiche/new.html.twig', [
            'fiche' => $fiche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/affectationf/{id_fiche}", name="affecf")
     */
    public function newOrg(Request $request, $id_fiche): Response
//    public function newOrg(Request $request,Rubrique $id,Organisme $organisme,OrganismeRepository $organismeRepository):Response
    {
        $rub = new Rubrique();
        $form = $this->createForm(RubriqueType::class,$rub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fiche = $this->getDoctrine()->getRepository(Fiche::class)->findOneBy(['id' => $id_fiche]);
                $fiche->addRubrique($rub);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($rub);
                $entityManager->flush();
                //$entityManager = $this->getDoctrine()->getManager();
                //$entityManager->persist($fiche);
                //$entityManager->flush();
                return $this->redirectToRoute('Rub_aff');
            }

        return $this->render('rubrique/new.html.twig', [
            'rubrique' => $rub,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/editfiche", name="fiche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fiche $fiche): Response
    {
        $fiche->setModifAuto(new \DateTime('now'));
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiche_aff');
        }

        return $this->render('fiche/edit.html.twig', [
            'fiche' => $fiche,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("Lafiche/{id_fiche}", name="La_fiche", methods={"GET","POST"})
     */
    public  function Fiche(Request $request,$id_fiche):Response
    {
        $fiche=$this->getDoctrine()->getRepository(Fiche::class)->findOneBy(['id' => $id_fiche]);
        //$fiche=$this->getDoctrine()->getRepository(Fiche::class)->findOneBy($fichename);
       //fiche = new Fiche();
        //dump($fiche);die();
        //$sql=Select id
          //  from fiche
            //where $fiche;
       // $id_rubrique=
        //$id_rubriques=$id_rubrique['rubrique'];
                $rubriques = $this->getDoctrine()->getRepository(Rubrique::class)->findBy(['fiche' => $fiche]);//$fiche
        //dump ($rubriques);die();
        $i=0;
        $z=0;
        $e=0;
      //  $rubrique_id=0;
        foreach($rubriques as $rubrique) {//trouver l'id
            $id_rubrique = $rubrique->getId();


            //$rubrique_id=$this->getDoctrine()->getRepository(Rubrique::class)->find(['id'=>$rubrique]);
            $em = $this->getDoctrine()->getManager();
            //dump($rubrique_id);die();
            //$em=(string)$rubrique_id;
            //dump($em);die();
            $RAW_QUERY = 'SELECT rubrique_organisme.organisme_id
                          FROM rubrique
                          INNER join rubrique_organisme on rubrique.id=rubrique_organisme.rubrique_id
                          Where rubrique.id =
                           :id_rubrique';
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->bindValue('id_rubrique', $id_rubrique);
            $statement->execute();

            $result = $statement->fetchAll();

            $organismes[$i] =$result;
            //$temp[$i]=$organismes[$i];
           //dump($organismes);die();
            //$rubrique_id=$this->getDoctrine()->getRepository(Rubrique::class)->find(['id'=>$rubrique]);
            //$rub=$this->getDoctrine()->getRepository(Rubrique::class)->findAll()$result;
            //dump($rubrique_id);die();                                                                      //findBy
            //foreach($rubriques as $rub) {
            //$rubrique = $this->getDoctrine()->getRepository(Rubrique::class)->findOneBy(['id' => $r]);
          //  $organisme = $this->getDoctrine()->getRepository(Organisme::class)->find(['id' => $result]);
            //$organismes[$i] = $this->getDoctrine()->getRepository(Rubrique::class)->findBy(['id' => 2]);
            //dump($organismes[0]);die();

            /*foreach($organismes as $organismeall) {

              $organismeall[$z] =$this->getDoctrine()->getRepository(Organisme::class)->findBy(['id'=>$organismes[$i]]);
              }
                $z++;*/
                //dump($org);die();

            //$organismes=$this->getDoctrine()->getRepository(Organisme::class)->findBy(['rubrique' => $rubriques]);//findall
            //dump($organismes);die();
            //foreach($organismes as $org){
            //    $organisme=$this->getDoctrine()->getRepository(Organisme::class)->findOneBy(['rubrique' => $org]);
            //}
//           }

            //dump($organisme[$i]);die();
            $i++;
        }

        //foreach($organismes as $organisme){
          //  $organisme= $this->getDoctrine()->getRepository(Organisme::class)->findAll();
        //}
        //dump($organismes);die();
        //dump($organisme);die();
        //dump($id_rubrique);die();
        return $this->render('fiche/Fiche.html.twig', [
            'fichev' => $fiche,
            'rubriques' =>$rubriques,
            'organismes' =>$organismes,
            //'torganisme' =>$organismeall,
            'result' => $result,
            //'temp' => $temp,
            'i' => $i,
           // 'organisme_id' => $organisme_id,
            'id_rubrique' =>$id_rubrique,
        ]);

    }

}


   /* public function RefId($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $fiche = $em->getRepository('App\Entity\Fiche')->find($id);

        if (null === $fiche) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }

        // On boucle sur les catégories de l'annonce pour les supprimer
        foreach ($fiche->getReferentId() as $referent) {
            $fiche->add($referent);
        }

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine

        // On déclenche la        modification
        $em->flush();

        // ...
    }*/
