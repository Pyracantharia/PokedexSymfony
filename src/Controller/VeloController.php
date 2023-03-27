<?php

namespace App\Controller;

use App\Entity\Velo;
use App\Form\VeloType;
use App\Repository\VeloRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/velo')]
class VeloController extends AbstractController
{
    #[Route('/', name: 'app_velo_index', methods: ['GET'])]
    public function index(VeloRepository $veloRepository): Response
    {
        return $this->render('velo/index.html.twig', [
            'velos' => $veloRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_velo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VeloRepository $veloRepository): Response
    {
        $velo = new Velo();
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veloRepository->add($velo);
            return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('velo/new.html.twig', [
            'velo' => $velo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_velo_show', methods: ['GET'])]
    public function show(Velo $velo): Response
    {
        return $this->render('velo/show.html.twig', [
            'velo' => $velo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_velo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Velo $velo, VeloRepository $veloRepository): Response
    {
        $form = $this->createForm(VeloType::class, $velo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veloRepository->add($velo);
            return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('velo/edit.html.twig', [
            'velo' => $velo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_velo_delete', methods: ['POST'])]
    public function delete(Request $request, Velo $velo, VeloRepository $veloRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$velo->getId(), $request->request->get('_token'))) {
            $veloRepository->remove($velo);
        }

        return $this->redirectToRoute('app_velo_index', [], Response::HTTP_SEE_OTHER);
    }
}
