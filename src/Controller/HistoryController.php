<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    /**
     * @Route("/history", name="history")
     */
    public function index(UserRepository $userRepository): Response
    {   
        return $this->render('history/index.html.twig', [
            'upokemon' => $userRepository->findAllUserWithPokemon('Pikachu'),
        ]);
    }
}
