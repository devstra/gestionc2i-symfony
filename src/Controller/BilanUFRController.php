<?php

namespace App\Controller;

use App\Repository\EpreuveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BilanUFRController extends AbstractController
{
    /**
     * @Route("/bilanufr", name="bilan_u_f_r")
     */
    public function index(EpreuveRepository $epreuveRepository): Response
    {
        return $this->render('bilan_ufr/index.html.twig', [
            'epreuves' => $epreuveRepository->findAll(),
        ]);
    }
}
