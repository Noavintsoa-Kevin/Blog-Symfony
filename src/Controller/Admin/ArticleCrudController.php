<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('Titre');
        
        yield SlugField::new('Slug')
            ->setTargetFieldName('Titre');
        
        yield TextEditorField::new('Content');


        yield TextField::new('Description_Text');
        yield AssociationField::new('categories');


        yield DateTimeField::new('createdAt')
            ->hideOnForm();

        yield DateTimeField::new('updatedAt')
            ->hideOnForm();
        
    }
    
}
