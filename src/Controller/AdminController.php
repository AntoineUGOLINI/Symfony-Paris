<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
  * Require ROLE_ADMIN for *every* controller method in this class.
 *
  * @IsGranted("ROLE_ADMIN")
 */

class AdminController extends AbstractController
{
    /**
         * Require ROLE_ADMIN for only this controller method.
          *
          * @IsGranted("ROLE_ADMIN")
          */
#{% if is_granted('ROLE_ADMIN') %}
#<a href="...">Delete</a>
#{% endif %}
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * Route("/dashboard", name="dash")
     */
    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = $this->getUser();
        return new Response('Well hi there '.$user->getFirstName());
        // ...
    }
}
