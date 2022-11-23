<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\CommentaireRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User getUser()
 */
class CommentaireController extends AbstractController
{
    #[Route('/ajax/commentaire', name: 'commentaire_add')]
    public function add(Request $request, ArticleRepository $articleRepository, CommentaireRepository $commentaireRepository,EntityManagerInterface $entityManager,UserRepository $userRepository, User $user): Response
    {
        $commentData = $request->request->all('comment');
        if(!$this->isCsrfTokenValid('comment-add', $commentData['_token'])){
            return $this->json([
                'code'=>'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        $article=$articleRepository->findOneBy(['id'=>$commentData['article']]);

        if(!$article){
            return $this->json([
                'code'=>'ARTICLE NOT FOUND'
            ], Response::HTTP_BAD_REQUEST);
        }
        $user ->$this->getUser();

        if(!$user)
        {
            return $this -> json([
                'code'=> 'USER_NOT_AUTHENTICATED_FULLY'
            ], Response::HTTP_BAD_REQUEST);
        }
        $commentaire=new Commentaire($article);
        $commentaire->setContenue($commentData['contenue']);
        $commentaire->setUser($user);
        $commentaire->setCreatedAt(new \DateTime());
        $entityManager->persist($commentaire);
        $entityManager->flush();
        
        $a=$this->renderView('commentaire/index.html.twig',[
            'commentaire'=>$commentaire
        ]);
        return $this->json([
            'code'=>'COMMENT_ADD_SUCCESSFULLY',
            'message'=>$a,
            'nombredecommentaire'=>$commentaireRepository->count(['Article'=>$article])
        ]);
    }
}
