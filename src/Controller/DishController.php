<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/dish')]
class DishController extends AbstractController
{
    #[Route('/', name: 'app_dish_index', methods: ['GET'])]
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('dish/index.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }


    #[Route('/all', name: 'carte_all', methods: ['GET'])]
    public function all(DishRepository $dishRepository): Response
    {
        return $this->render('pages/carte_All.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_dish_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                     // affichage d'image start

        // $user= $this->getUser();
        // $starter->setUser($user);

        $image = $form->get('image')->getData();

        // Si une image a été uploadée
        if ($image) {

            // 2 - Modifier le nom de l'image (nom unique)
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

            // Transforme le nom de l'image en slug pour l'URL (minuscule, sans accent, sans espace, etc.)
            $safeFilename = $slugger->slug($originalFilename);

            // Reconstruit le nom de l'image avec un identifiant unique et son extension
            $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

            // 3 - Enregistrer l'image dans son répertoire ('articles_images')
            try {
                $image->move(
                    $this->getParameter('dish_images'),
                    $newFilename
                );
            } catch (FileException $e) {
                
            }

            // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
            $dish->setImage($newFilename);
        }
// affichage d'image end



            $entityManager->persist($dish);
            $entityManager->flush();

            return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_show', methods: ['GET'])]
    public function show(Dish $dish): Response
    {
        return $this->render('dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dish_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dish $dish, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dish/edit.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_delete', methods: ['POST'])]
    public function delete(Request $request, Dish $dish, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dish);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
    }
}
