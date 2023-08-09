<?php

namespace App\Controller;

use App\Entity\Dessert;
use App\Form\DessertType;
use App\Repository\DessertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/dessert')]
class DessertController extends AbstractController
{
    #[Route('/', name: 'app_dessert_index', methods: ['GET'])]
    public function index(DessertRepository $dessertRepository): Response
    {
        return $this->render('dessert/index.html.twig', [
            'desserts' => $dessertRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dessert_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $dessert = new Dessert();
        $form = $this->createForm(DessertType::class, $dessert);
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
                    $this->getParameter('dessert_images'),
                    $newFilename
                );
            } catch (FileException $e) {
                
            }

            // 4 - Ajouter le nom de l'image à l'objet en cours (setImage)
            $dessert->setImage($newFilename);
        }
// affichage d'image end






            $entityManager->persist($dessert);
            $entityManager->flush();

            return $this->redirectToRoute('app_dessert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dessert/new.html.twig', [
            'dessert' => $dessert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dessert_show', methods: ['GET'])]
    public function show(Dessert $dessert): Response
    {
        return $this->render('dessert/show.html.twig', [
            'dessert' => $dessert,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dessert_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dessert $dessert, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DessertType::class, $dessert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dessert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dessert/edit.html.twig', [
            'dessert' => $dessert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dessert_delete', methods: ['POST'])]
    public function delete(Request $request, Dessert $dessert, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dessert->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dessert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dessert_index', [], Response::HTTP_SEE_OTHER);
    }
}
