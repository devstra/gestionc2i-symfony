<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Form\CopieType;
use App\Repository\CopieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/copie")
 */
class CopieController extends AbstractController
{
    /**
     * @Route("/", name="copie_index", methods={"GET"})
     */
    public function index(CopieRepository $copieRepository): Response
    {
        return $this->render('copie/index.html.twig', [
            'copies' => $copieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="copie_new", methods={"GET","POST"})
     */
    function new (Request $request): Response {
        $copie = new Copie();
        $form = $this->createForm(CopieType::class, $copie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Calcul du domaine 3 sur /5 en fonction des sous-notes entrées
            $noteD3 = round((($copie->getNoteTableur() / 4) + $copie->getNoteTraitementTexte() + $copie->getNotePresentationAO()) / 3, 2);

            $copie->setNoteD3($noteD3);

            // Calcul de la note finale sur /20 en fonction des notes entrées
            $noteFinale = round((($copie->getNoteD1() + $copie->getNoteD2() + $copie->getNoteD3() + $copie->getNoteD4() + $copie->getNoteD5()) / 5) * 4, 2);

            $copie->setNoteFinale($noteFinale);

            // on récupère la barre de l'épreuve pour cette copie
            $barre = $copie->getEpreuve()->getBarre();

            // On détermine les mentions en fonction des notes renseignées
            $mentionD1 = ($copie->getNoteD1() >= $barre) ? 'ADM' : (($copie->getNoteD1() >= 2.5) ? 'MOY' : 'AJ');
            $mentionD2 = ($copie->getNoteD2() >= $barre) ? 'ADM' : (($copie->getNoteD2() >= 2.5) ? 'MOY' : 'AJ');
            $mentionD3 = ($copie->getNoteD3() >= $barre) ? 'ADM' : (($copie->getNoteD3() >= 2.5) ? 'MOY' : 'AJ');
            $mentionD4 = ($copie->getNoteD4() >= $barre) ? 'ADM' : (($copie->getNoteD4() >= 2.5) ? 'MOY' : 'AJ');
            $mentionD5 = ($copie->getNoteD5() >= $barre) ? 'ADM' : (($copie->getNoteD5() >= 2.5) ? 'MOY' : 'AJ');

            $copie->setMentionD1($mentionD1);
            $copie->setMentionD2($mentionD2);
            $copie->setMentionD3($mentionD3);
            $copie->setMentionD4($mentionD4);
            $copie->setMentionD5($mentionD5);

            $mentions = array($mentionD1, $mentionD2, $mentionD3, $mentionD4, $mentionD5);
            $nbMentions = array_count_values($mentions);

            if ($nbMentions['ADM'] == 5) {
                $copie->setMentionFinale('ADM');
            } elseif ($nbMentions['ADM'] == 4 && $nbMentions['MOY'] == 1) {
                $copie->setMentionFinale('ADM');
            } else {
                $copie->setMentionFinale('AJ');
            }

            $entityManager->persist($copie);
            $entityManager->flush();

            return $this->redirectToRoute('copie_index');
        }

        return $this->render('copie/new.html.twig', [
            'copie' => $copie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="copie_show", methods={"GET"})
     */
    public function show(Copie $copie): Response
    {
        return $this->render('copie/show.html.twig', [
            'copie' => $copie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="copie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Copie $copie): Response
    {
        $form = $this->createForm(CopieType::class, $copie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('copie_index');
        }

        return $this->render('copie/edit.html.twig', [
            'copie' => $copie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="copie_delete", methods={"POST"})
     */
    public function delete(Request $request, Copie $copie): Response
    {
        if ($this->isCsrfTokenValid('delete' . $copie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($copie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('copie_index');
    }
}
