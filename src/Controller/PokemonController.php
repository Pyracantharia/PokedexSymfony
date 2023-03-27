<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Form\SearchType;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/pokemon", name="pokemon_")
 * @package App\Controller
 */
class PokemonController extends AbstractController {

    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function index(PokemonRepository $pokemonRepository, PaginatorInterface $paginator, Request $request): Response 
    {   
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $findPokemon = $paginator->paginate(
                $pokemonRepository->findByPokemonNameSearch($data['q']),
                $request->query->getInt('page', 1), /*page number*/
                6 /*limit per page*/
            );

            return $this->render('pokemon/index.html.twig', [
                'pokemons' => $findPokemon,
                'form' => $form->createView()
            ]); 
        }
    
        /**
         * Récupere les pokémons par pagination
         */
        $findPokemon = $paginator->paginate(
            $pokemonRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        /**
         * On récupere la liste des pokemon grâce au findAll
         */
        return $this->render('pokemon/index.html.twig', [
            'pokemons' => $findPokemon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"POST", "GET"})
     */
    public function new(Request $request, PokemonRepository $pokemonRepository): Response {
        /**
         * On envoie un pokemon dans la db
         */
        $pokemon = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pokemon);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pokemonRepository->add($pokemon);
            $this->addFlash('success', 'Pokemon enregistré');
            return $this->redirectToRoute('pokemon_index');
        }

        return $this->render('pokemon/new.html.twig', [
            'pokemon' => $pokemon,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Pokemon $pokemon): Response
    {
        /**
         * On regarde un pokemon en particulier en fonction de l'id
         */
        return $this->render('pokemon/show.html.twig', [
            'pokemon' => $pokemon
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */

     public function edit(Request $request, Pokemon $pokemon, PokemonRepository $pokemonRepository): Response {
        $form = $this->createForm(PokemonType::class, $pokemon);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pokemonRepository->add($pokemon);
            $this->addFlash('success', 'Pokemon edité');
            return $this->redirectToRoute('pokemon_index');
        }

        return $this->render('pokemon/edit.html.twig', [
            'pokemon' => $pokemon,
            'form' => $form->createView()
        ]);

     }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Pokemon $pokemon, PokemonRepository $PokemonRepository): Response {
        /**
         * On supprimer un pokemon
         */
        
        $PokemonRepository->remove($pokemon);
        $this->addFlash('success', 'Pokemon supprimé');

        return $this->redirectToRoute('pokemon_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/test", name="test")
     * @return Response
     */
    public function test(Request $request): Response
    {   

        /**
         * Appel du formulaire
         */
        $form = $this->CreateForm(PokemonType::class);  

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data[] = $form->getData();
        }

        $getDataForm = isset($data) ? $data[0] : null;

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
            'data' => $getDataForm
        ]);
    }

}



