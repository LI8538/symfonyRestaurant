<?php

namespace App\Controller\Admin;

use App\Entity\Drink;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DrinkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Drink::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
