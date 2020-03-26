<?php

namespace App\Controller;

use App\Entity\Organisme;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Fiche;
use App\Form\FicheType;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\FicheRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Form\UserEditType;
use App\Form\OrganismeType;
use Spipu\Html2Pdf\Html2Pdf;
use App\Form\UsermdpType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_SUPER_ADMIN")
 */

$encoders = array(new XmlEncoder(), new JsonEncoder());
$serializer = new Serializer(array(), $encoders);

class UserController extends AbstractController
{

    /**
     * @Route("/User", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/Suppruse/{id}", name="use_supr")
     */
    public function Supprref(Request $request, User $user): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('App_aff_ref');
    }

    /**
     * @Route("/AffUs", name="App_aff_ref", methods={"GET"})
     */
    public function aff(UserRepository $userRepository): Response
    {
        return $this->render('user/editer.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newUs", name="use_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder)
        // 1) build the form
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('App_aff_ref');
        }
        return $this->render(
            'user/new.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/{id}/edituse", name="use_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('App_aff_ref');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editusemdp", name="use_edit_mdp", methods={"GET","POST"})
     */
    public function editmdp(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UsermdpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('App_aff_ref');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/affectationuf/{id_user}", name="affecuf")
     */
    public function newfiche(Request $request, $id_user): Response
    {
        $fiche = new Fiche();
        $form = $this->createForm(FicheType::class, $fiche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id_user]);
            $user->addFiche($fiche);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fiche);
            $entityManager->flush();
            //$entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($fiche);
            //$entityManager->flush();
            return $this->redirectToRoute('fiche_aff');
        }

        return $this->render('fiche/new.html.twig', [
            'fiche' => $fiche,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/affectationuo/{id_user}", name="affecuo")
     */
    public function neworg(Request $request, $id_user): Response
    {
        $organisme = new Organisme();
        $organisme->setCreaAuto(new \DateTime('now'));
        $form = $this->createForm(OrganismeType::class, $organisme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id' => $id_user]);
            $user->addOrganisme($organisme);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisme);
            $entityManager->flush();
            //$entityManager = $this->getDoctrine()->getManager();
            //$entityManager->persist($fiche);
            //$entityManager->flush();
            return $this->redirectToRoute('orga_aff');
        }

        return $this->render('organisme/new.html.twig', [
            'organisme' => $organisme,
            'form' => $form->createView(),
        ]);

    }

   /* public function checkPassword(Request $request): JsonResponse
    {
        $clearPassword = $request->request->get('plainPassword');
        $constraints = [
            new NotCompromisedPassword(),
        ];

        $violations = $this->validator->validate($clearPassword, $constraints);
        $messages = [];
        if ($violations->count()) {
            foreach ($violations as $violation) {
                if ($violation instanceof ConstraintViolation) {
                    $message = $violation->getMessage();
                    $message = \is_string($message) ? $message : '';
                    $messages[] = '❌ ' . $message . ' ❌';
                }
            }
        } else {
            $messages[] = '✅ This password has NOT been leaked in a data breach. ✅';
        }
        return

    }*/

}
