<?php

namespace App\Controller;

use App\Entity\Epreuve;
use App\Form\EpreuveType;
use App\Repository\EpreuveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/epreuve")
 */
class EpreuveController extends AbstractController
{
    /**
     * @Route("/", name="epreuve_index", methods={"GET"})
     */
    public function index(EpreuveRepository $epreuveRepository): Response
    {
        return $this->render('epreuve/index.html.twig', [
            'epreuves' => $epreuveRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="epreuve_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $epreuve = new Epreuve();
        $form = $this->createForm(EpreuveType::class, $epreuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($epreuve);
            $entityManager->flush();

            return $this->redirectToRoute('epreuve_index');
        }

        return $this->render('epreuve/new.html.twig', [
            'epreuve' => $epreuve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="epreuve_show", methods={"GET"})
     */
    public function show(Epreuve $epreuve): Response
    {
        return $this->render('epreuve/show.html.twig', [
            'epreuve' => $epreuve,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="epreuve_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Epreuve $epreuve): Response
    {
        $form = $this->createForm(EpreuveType::class, $epreuve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('epreuve_index');
        }

        return $this->render('epreuve/edit.html.twig', [
            'epreuve' => $epreuve,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="epreuve_delete", methods={"POST"})
     */
    public function delete(Request $request, Epreuve $epreuve): Response
    {
        if ($this->isCsrfTokenValid('delete'.$epreuve->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($epreuve);
            $entityManager->flush();
        }

        return $this->redirectToRoute('epreuve_index');
    }
}
