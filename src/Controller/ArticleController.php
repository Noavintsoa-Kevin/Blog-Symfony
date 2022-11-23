<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Article;
use App\Form\CommentType;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ArticleController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article, Request $request): Response
    {
        if (!$article) {
            return $this->redirectToRoute('app_accueil');
        }   
        $commentaire =new Commentaire($article);
        $commentaireForm =  $this->createForm(CommentType::class, $commentaire);
     
        return $this->renderForm('article/show.html.twig', [
            "article"=>$article,
            'commentaire_form'=>$commentaireForm
        ]);
     
    }
       
        
       
     
  
        
    
  }
