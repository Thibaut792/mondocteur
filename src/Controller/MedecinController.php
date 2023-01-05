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
    public function index(DocteurRepository $docteurRepository, RDVRepository $rdvRepository): Response
    {
        $docteurs = $docteurRepository->findAll();
        $nbrdv = $rdvRepository->findNbRdvInCurrentMonth();
        dd($nbrdv);
        return $this->render('medecin/index.html.twig', [
            'docteurs' => $docteurs,
        ]);
    }

    /**
     * @Route("/medecin/{id<\d+>}", name="app_medecin_view")
     */
    public function view(DocteurRepository $docteurRepository, $id): Response
    {
        $docteur = $docteurRepository->find($id);

        return $this->render('medecin/view.html.twig', [
            'medecin_id' => $id,
            'docteur' => $docteur,
        ]);
    }

    /**
     * @Route("/medecinAdd", name="medecin_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $docteur = new Docteur();
        $form = $this->createForm(DocteurType::class, $docteur);

        $manager = $doctrine->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $docteur = $form->getData();
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
}
