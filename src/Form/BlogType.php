<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\BlogStatus;
use App\Entity\Category;
use App\Form\DataTransformer\TagTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BlogType extends AbstractType
{
    public function __construct(private readonly TagTransformer $transformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['required' => true]) // валидация на клиенте
            ->add('description', TextType::class, ['required' => true])
            ->add('text', TextareaType::class, ['required' => true])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('blogStatus', EntityType::class, [
                'class' => BlogStatus::class,
                'choice_label' => 'name',
            ])
            ->add('tags', TextType::class, [
                'label' => 'Теги',
                'required' => false
            ]);
        $builder->get('tags')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
            // 'csrf_protection' => false // отключение csrf
        ]);
    }
}
