<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Review;
use App\Entity\Category;
use App\Entity\Publication;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');



         // Création d'un utilisateur ADMIN
        $user = new User();
        $user->setEmail('hello@restaurant.fr')
        ->setName('admin')
        ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp : admin
        ->setRoles(["ROLE_ADMIN"])
        ;
        
        // Enregistrement de l'utilisateur ADMIN en base de données
        $manager->persist($user);

        // Création d'un utilisateur USER
        $user2 = new User();
        $user2->setEmail('user@restaurant.fr')
        ->setName('user')
        ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp : admin
        ->setRoles(["ROLE_USER"])
        ;

        // Enregistrement de l'utilisateur USER en base de données
        $manager->persist($user2);






        for ($i=0; $i < 25 ; $i++) { 
           $avis = new Review();
           $avis->setName($faker->name());
           $avis->setDatePublication($faker->dateTimeBetween('-7 months'));
           $avis->setMessage($faker->text());
        // la note se régle entre 4 étoiles et 5 étoiles
           $avis->setNote($faker->numberBetween(4,5));
           $manager->persist($avis);
        }

          // Boucle pour créer 200 snippets de test
        // for ($i=0; $i < 20; $i++) { 
        //     $publication = new Publication();
        //     $publication->setTitle($faker->word(8));
        //     $publication->setContent($faker->text());
        //     $publication->setPublishedAt($faker->dateTimeBetween('-7 months'));
        //     $publication->$faker->ImageUrl();
        //     $publication->SetCategory();

        //     $manager->persist($publication);
        // }
        
        // $manager->persist($product);




         // PUBLICATION
         $publications = [
            [
                'title' => 'Découvrez notre nouvelle carte automne-hiver !',
                'content' => 'Plongez dans une expérience culinaire unique avec nos plats réconfortants de saison. Des saveurs qui éveilleront vos sens et vous transporteront au cœur de l\'hiver.',
                'image' => '1.jpg'
            ],
            [
                'title' => 'Réservez dès maintenant pour notre soirée spéciale vin et fromage',
                'content' => 'Amateurs de vin et de fromage, ne manquez pas notre soirée spéciale où vous pourrez déguster une sélection exquise de vins accompagnée des meilleurs fromages locaux.',
                'image' => '2.jpg'
            ],
            [
                'title' => 'Offre d\'emploi : Rejoignez notre équipe en cuisine !',
                'content' => 'Nous recherchons un chef passionné et créatif pour rejoindre notre équipe. Si vous avez de l\'expérience en cuisine gastronomique et souhaitez faire partie d\'une équipe dynamique, postulez dès maintenant.',
                'image' => '3.jpg'
            ],
            [
                'title' => 'Témoignage client : Une soirée inoubliable à La Table Élégance',
                'content' => "Nous avons passé une soirée incroyable à La Table Élégance. Le service était impeccable, la nourriture délicieuse et l'ambiance chaleureuse. Chaque plat était une explosion de saveurs et nous avons été agréablement surpris par la créativité du chef. Un grand merci à toute l'équipe pour cette expérience inoubliable.",
                'image' => '4.jpg'
            ],
            [
                'title' => 'Réduction spéciale pour les anniversaires !',
                'content' => 'Célébrez votre anniversaire chez nous et bénéficiez d\'une réduction spéciale de 20% sur votre repas. Rendez-vous à La Table Élégance pour une expérience culinaire exceptionnelle.',
                'image' => '5'
            ]
        ];
        
        // Utilisation de $publications avec Faker pour les autres données aléatoires
        // foreach ($publications as $publication) {
        //     $title = $publication['title'];
        //     $content = $publication['content'];
        //     $image = $publication['image'];
        


        // CATÉGORIES
        // Je liste les catégories que je veux créer
        $categories = [
            'Événement',
            'Réseaux sociaux',
            'Restaurants',
            'Emploi'
        ];

        foreach ($categories as $item) {

            // Je crée un nouvel objet catégorie
            $categorie = new Category();
            // J'utilise la méthode setName pour définir le nom de la catégorie
            $categorie->setName($item);
            // J'enregistre la catégorie en base de données avec Doctrine
            $manager->persist($categorie);
        }



        foreach ($publications as $item) {
            // // AUTEURS
            // // Je crée un nouvel objet auteur
            // $user = new User();
            // // J'utilise la méthode setName pour définir le nom de l'auteur
            // $user->setName($faker->name());
            // // J'enregistre l'auteur en base de données avec Doctrine
            // $manager->persist($user);


            // Je crée un nouvel objet article
            $publications = new Publication();
            // J'utilise la méthode setTitle pour définir le titre de l'article
            $publications->setTitle($item['title']);
            // J'utilise la méthode setContent pour définir le contenu de l'article
            $publications->setContent($item['content']);
            // J'utilise la méthode setCategory pour définir la catégorie de l'article
            $publications->setCategory($categorie);
            // J'utilise la méthode setAuthor pour définir l'auteur de l'article
            $publications->setUser($user);
            $publications->setPublishedAt($faker->dateTimeBetween('-7 months'));
            // J'utilise la méthode setAuthor pour définir l'auteur de l'article
            $publications->setImage($item['image']);
            // J'enregistre l'article en base de données avec Doctrine
            $manager->persist($publications);
        }

          // Boucle pour créer 200 snippets de test
        // for ($i=0; $i < 20; $i++) { 
        //     $publication = new Publication();
        //     $publication->setTitle($faker->word(8));
        //     $publication->setContent($faker->text());
        //     $publication->setPublishedAt($faker->dateTimeBetween('-7 months'));
        //     $publication->$faker->ImageUrl();
        //     $publication->SetCategory();

        //     $manager->persist($publication);
        // }







        $manager->flush();
    }
}
