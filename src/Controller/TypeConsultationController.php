<?php

namespace App\Controller;

use App\Entity\TypeConsultation;
use App\Form\TypeConsultationType;
use App\Repository\TypeConsultationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/typeconsult")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class TypeConsultationController extends AbstractController
{
    /**
     * @Route("/", name="app_type_consultation_index", methods={"GET"})
     */
    public function index(TypeConsultationRepository $typeConsultationRepository): Response
    {
        return $this->render('type_consultation/index.html.twig', [
            'type_consultations' => $typeConsultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_type_consultation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TypeConsultationRepository $typeConsultationRepository): Response
    {
        $typeConsultation = new TypeConsultation();
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeConsultationRepository->add($typeConsultation, true);

            return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_consultation/new.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_consultation_show", methods={"GET"})
     */
    public function show(TypeConsultation $typeConsultation): Response
    {
        return $this->render('type_consultation/show.html.twig', [
            'type_consultation' => $typeConsultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_type_consultation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TypeConsultation $typeConsultation, TypeConsultationRepository $typeConsultationRepository): Response
    {
        $form = $this->createForm(TypeConsultationType::class, $typeConsultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeConsultationRepository->add($typeConsultation, true);

            return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_consultation/edit.html.twig', [
            'type_consultation' => $typeConsultation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_type_consultation_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeConsultation $typeConsultation, TypeConsultationRepository $typeConsultationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $typeConsultation->getId(), $request->request->get('_token'))) {
            $typeConsultationRepository->remove($typeConsultation, true);
        }

        return $this->redirectToRoute('app_type_consultation_index', [], Response::HTTP_SEE_OTHER);
    }
}
