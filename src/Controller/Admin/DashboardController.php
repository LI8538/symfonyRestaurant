<?php

namespace App\Controller\Admin;

use App\Entity\Dish;
use App\Entity\User;
use App\Entity\Drink;
use App\Entity\Review;
use App\Entity\Dessert;
use App\Entity\Starter;
use App\Entity\Category;
use App\Entity\Publication;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }



    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La table élégance Dashbord');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Réservation', 'fas fa-calendar-days', Reservation::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Publications', 'fas fa-envelope', Publication::class);
        yield MenuItem::linkToCrud('Reviews', 'fas fa-comments', Review::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-folder-open', Category::class);
        //gestion la carte
        yield MenuItem::section('Gestion la carte');
        yield MenuItem::linkToCrud('Entrée', 'fas fa-egg', Starter::class);
        yield MenuItem::linkToCrud('Plats', 'fas fa-utensils', Dish::class);
        yield MenuItem::linkToCrud('Desserts', 'fas fa-cookie-bite', Dessert::class);
        yield MenuItem::linkToCrud('Boisson && Cocktail', 'fas fa-champagne-glasses', Drink::class);

        yield MenuItem::section('Autres');
        yield MenuItem::linkToRoute('Retour à la page d\'accueil', 'fas fa-arrow-left', 'app_home');
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-arrow-right-from-bracket');
    }
}
