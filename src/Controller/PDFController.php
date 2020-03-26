<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Spipu\Html2Pdf\Html2Pdf;


/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_USER")
 */

class PDFController extends AbstractController
{
    /**
     * @Route("/pdof", name="p_d_f")
     */
    public function index()
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PDFController',
        ]);
    }

    /**
     * @Route("/{id_fiche}/pdf", name="pdf")
     */
    public function pdf($id_fiche)
    {
        $fiche=$this->getDoctrine()->getRepository(Fiche::class)->findOneBy(['id' => $id_fiche]);
        $rubriques = $this->getDoctrine()->getRepository(Rubrique::class)->findBy(['fiche' => $fiche]);//$fiche
        $i=0;
        foreach($rubriques as $rubrique) {//trouver l'id
            $id_rubrique = $rubrique->getId();
            $em = $this->getDoctrine()->getManager();
            $RAW_QUERY = 'SELECT rubrique_organisme.organisme_id
                          FROM rubrique
                          INNER join rubrique_organisme on rubrique.id=rubrique_organisme.rubrique_id
                          Where rubrique.id = :id_rubrique';
            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->bindValue('id_rubrique', $id_rubrique);
            $statement->execute();
            $result = $statement->fetchAll();
            $organismes[$i] =$result;
            $i++;
        }
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('fiche/pdf.html.twig', [
                'fichev' => $fiche,
                'rubriques' =>$rubriques,
                'organismes' =>$organismes,
                'result' => $result,
                'i' => $i,
                'id_rubrique' =>$id_rubrique,
            ]);
        /*$html = $this->renderView('fiche/Fiche.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);*/
        //$html="<p>Hello</p>";
        //$html=file_get_contents('http://localhost/Symfo2/Symfo2/public/Lafichepourpdf.html');
        //$html=file_get_contents('http://localhost/Symfo2/Symfo2/public/Lafiche/'.$id_fiche.'');
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A1', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf"
        );
        return $this->render('fiche/pdf.html.twig', [
            'fichev' => $fiche,
            'rubriques' =>$rubriques,
            'organismes' =>$organismes,
            //'torganisme' =>$organismeall,
            'result' => $result,
            'i' => $i,
            'id_rubrique' =>$id_rubrique,
        ]);
    }




}
