<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Commentaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder

           
            ->add('contenue',TextareaType::class, array(
                'label'=>'Votre commentaire'
            ))
            ->add('article', HiddenType::class)
            ->add('envoyer', SubmitType::class)    
        ;
        $builder
            ->get('article')
            ->addModelTransformer(new CallbackTransformer(
                fn(Article $article) =>$article->getId(),
                fn(Article $article) =>$article->getTitre()));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
            'csrf_token_id' => 'comment-add'
        ]);
    }
}
