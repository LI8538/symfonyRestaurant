<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FirstController extends AbstractController
{
    #[Route('/first/Wang', name: 'app_first')]
    public function index(): Response
    {
        // die(' je suis la requete /first');
        return $this->render('first/index.html.twig', [
            // 'controller_name' => 'FirstController',
            'name' => 'Li',
            'firstname' => 'Wang'
        ]);
    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say_hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
    dd ($request);
        return $this->render('first/hello.html.twig', [
            'nom' => $name,
            'prenom' => $firstname,
        ]);
    }
}
