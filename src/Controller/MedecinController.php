<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\DocteurType;
use App\Repository\DocteurRepository;
use App\Repository\RDVRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="app_medecin")
     */
    public function index(DocteurRepository $docteurRepository, RDVRepository $rdvRepository, Request $request): Response
    {
        $docteurs = $docteurRepository->findAll();
        $nbrdv = $rdvRepository->findNbRdvInCurrentMonth();
        $test = $rdvRepository->findNbRdvInCurrentMonth2();
        // dd($nbrdv);
        // dd($test);
        $session = $request->getSession();
        $medecinlast = $session->get("medecin-last");
        dd($medecinlast);
        return $this->render('medecin/index.html.twig', [
            'docteurs' => $docteurs,
        ]);
    }

    /**
     * @Route("/medecin/{id<\d+>}", name="app_medecin_view")
     */
    public function view(DocteurRepository $docteurRepository, $id, Request $request): Response
    {
        $docteur = $docteurRepository->find($id);

        $session = $request->getSession();
        $session->set('medecin-last', $id);


        return $this->render('medecin/view.html.twig', [
            'docteur' => $docteur,
        ]);
    }

    /**
     * @Route("/medecinAdd", name="medecin_add")
     * @IsGranted("ROLE_MEDECIN")
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($this->getUser()->getDocteur() != null) {
            //La fiche docteur n'existe pas
            $docteur = $this->getUser()->getDocteur();
        } else {
            //La fiche docteur existe
            $docteur = new Docteur();
        }
        $form = $this->createForm(DocteurType::class, $docteur);

        $manager = $doctrine->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $docteur = $form->getData();
            $docteur->setCompteUser($this->getUser());

            $manager->persist($docteur);
            $manager->flush();
            return $this->redirectToRoute("app_medecin_view", array("id" => $docteur->getId()));
        }

        //RenderForm pour afficher un formulaire
        //Symfony make:form pour faire un formulaire

        return $this->renderForm('medecin/add.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/rdvMedecin", name="app_rdvMedecin")
     * @IsGranted("ROLE_MEDECIN")
     */
    public function rdvMedecin(RDVRepository $RdvRepository): Response
    {
        $rdvDuJour = $RdvRepository->findRdvForOneDocteur($this->getUser()->getDocteur());
        dd($rdvDuJour);
        return $this->render('medecin/rdvMedecin.html.twig');
    }
}
