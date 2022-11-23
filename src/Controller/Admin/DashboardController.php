<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ArticleCrudController;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Commentaire;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $AdminUrlGenerator)
    {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {


        $url= $this ->AdminUrlGenerator->setController(ArticleCrudController::class)->generateUrl();
        return $this->redirect($url);

       
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
  
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles','fas fa-envelope', Article::class),
            MenuItem::linkToCrud('Ajouter les articles','fas fa-envelope', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Categories','fas fa-list', Category::class),         
        ]);
     

        yield MenuItem::linkToCrud('Commentaire', 'fas fa-comment', Commentaire::class);
        yield MenuItem:: linkToRoute('Retour sur le site', 'fas fa-undo', 'app_accueil'); 
    }
}
