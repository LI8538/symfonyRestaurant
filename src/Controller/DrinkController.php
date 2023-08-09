<?php

namespace App\Controller;

use App\Entity\Drink;
use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/drink')]
class DrinkController extends AbstractController
{
    #[Route('/', name: 'app_drink_index', methods: ['GET'])]
    public function index(DrinkRepository $drinkRepository): Response
    {
        return $this->render('drink/index.html.twig', [
            'drinks' => $drinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_drink_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $drink = new Drink();
        $form = $this->createForm(DrinkType::class, $drink);
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
                    $this->getParameter('drink_images'),
                    $newFilename
                );
            } catch (FileException $e) {
                
            }

            // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
            $drink->setImage($newFilename);
        }
// affichage d'image end







            $entityManager->persist($drink);
            $entityManager->flush();

            return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drink/new.html.twig', [
            'drink' => $drink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drink_show', methods: ['GET'])]
    public function show(Drink $drink): Response
    {
        return $this->render('drink/show.html.twig', [
            'drink' => $drink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_drink_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Drink $drink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DrinkType::class, $drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drink/edit.html.twig', [
            'drink' => $drink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_drink_delete', methods: ['POST'])]
    public function delete(Request $request, Drink $drink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$drink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($drink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
    }
}
