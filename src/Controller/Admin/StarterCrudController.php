<?php

namespace App\Controller\Admin;

use App\Entity\Starter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StarterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Starter::class;
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
