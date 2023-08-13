<?php

namespace App\Controller\Admin;

use App\Entity\Dessert;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DessertCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dessert::class;
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
