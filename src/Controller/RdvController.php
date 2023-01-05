<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Form\RDVType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeConsultationRepository;
use App\Repository\RDVRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class RdvController extends AbstractController
{
    /**
     * @Route("/rdv", name="app_rdv")
     */
    public function index(TypeConsultationRepository $typeConsultationRepository): Response
    {
        $typeConsult = $typeConsultationRepository->findAll();
        return $this->render('rdv/index.html.twig', [
            'types' => $typeConsult
        ]);
    }

    /**
     * @Route("/addrdv/{idTypeConsult}", name="app_addrdv")
     */
    public function addrdv($idTypeConsult, TypeConsultationRepository $typeConsultationRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $rdv = new RDV();
        $typeConsult = $typeConsultationRepository->find($idTypeConsult);
        $form = $this->createForm(RDVType::class, $rdv, ['medecin' => $typeConsult->getMedecin()]);


        $manager = $doctrine->getManager();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rdv = $form->getData();
            // on récuprer le user connecter
            $rdv->setUser($this->getUser());
            //on récupérer de type consultation
            $rdv->setTypeConsultation($typeConsult);
            $manager->persist($rdv);
            $manager->flush();
            return $this->redirectToRoute("app_mesrdv");
        }
        return $this->renderForm('rdv/add.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/mesrdv", name="app_mesrdv")
     */
    public function mesrdv(RDVRepository $RdvRepository): Response
    {
        $rdvs = $RdvRepository->findby(['user' => $this->getUser()], ['creneau' => 'DESC']);
        return $this->render('rdv/mesrdv.html.twig', [
            'rdvs' => $rdvs,
            'now' => new \DateTime()
        ]);
    }
}
