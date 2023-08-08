<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Repository\PublicationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReviewRepository $reviewRepository, PaginatorInterface $paginator, Request $request, PublicationRepository $PublicationRepository): Response
    {   
          // On créer une requête pour récupérer les snippets
        //    $user=$this->getUser();
        // dd($user);
        //  met dans le findBy ['user_id' => $user]

         // Récupérer les donnée de publications, avec trie de plus récent au plus anciens date
        $publications = $PublicationRepository->findBy([], ['publishedAt' => 'DESC']);



          $data = $reviewRepository->findBy([], ['datePublication' => 'DESC']);

            $pagination = $paginator->paginate(
            $data, // Requête contenant les données à paginer
            
            $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
            4 // Nombre de résultats par page
        );
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'reviews' => $pagination,
            // injecte les données et donne 'publications' accès au template que j'ai choisi
            'publications' => $publications
        ]);

    }




    // #[Route('/all', name: 'app_review_all')]
    // public function all(ReviewRepository $reviewRepository, PaginatorInterface $paginator, Request $request): Response
    // {   
    //       // On créer une requête pour récupérer les snippets
    //     //    $user=$this->getUser();
    //     // dd($user);
    //     //  met dans le findBy ['user_id' => $user]

    //      // Récupérer les donnée de publications, avec trie de plus récent au plus anciens date
     



    //       $data = $reviewRepository->findBy([], ['datePublication' => 'DESC']);

    //         $pagination = $paginator->paginate(
    //         $data, // Requête contenant les données à paginer
            
    //         $request->query->getInt('page', 1), // Numéro de la page en cours, 1 par défaut
    //         4 // Nombre de résultats par page
    //     );
        
    //     return $this->render('pages/review_All.html.twig', [
    //       'controller_name' => 'HomeController',
    //       'reviews' => $pagination,
    //   ]);
    // }
}