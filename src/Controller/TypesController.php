<?php

namespace App\Controller;

use App\Entity\Types;
use App\Form\TypesType;
use App\Repository\TypesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
/**
 * @Route("/types", name="types_")
 * @package App\Controller
 */
class TypesController extends AbstractController {

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(TypesRepository $typesRepository, PaginatorInterface $paginator, Request $request): Response 
    {   

        $findTypes = $paginator->paginate(
            $typesRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        /**
         * On récupere la liste des Types grâce au findAll
         */
        return $this->render('types/index.html.twig', [
            'types' => $findTypes
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"POST", "GET"})
     */
    public function new(Request $request, TypesRepository $typesRepository): Response {
        /**
         * On envoie un Types dans la db
         */
        $types = new Types();
        $form = $this->createForm(TypesType::class, $types);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $typesRepository->add($types);
            $this->addFlash('success', 'Types enregistré');
            return $this->redirectToRoute('types_index');
        }

        return $this->render('types/new.html.twig', [
            'types' => $types,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Types $types): Response
    {
        /**
         * On regarde un Types en particulier en fonction de l'id
         */
        return $this->render('types/show.html.twig', [
            'types' => $types
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */

     public function edit(Request $request, Types $types, TypesRepository $typesRepository): Response {
        $form = $this->createForm(TypesType::class, $types);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $typesRepository->add($types);
            $this->addFlash('success', 'Types edité');
            return $this->redirectToRoute('types_index');
        }

        return $this->render('types/edit.html.twig', [
            'types' => $types,
            'form' => $form->createView()
        ]);

     }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Types $types, TypesRepository $typesRepository): Response {
        /**
         * On supprimer un Types
         */
        
        $typesRepository->remove($types);
        $this->addFlash('success', 'Types supprimé');

        return $this->redirectToRoute('types_index', [], Response::HTTP_SEE_OTHER);
    }
}
