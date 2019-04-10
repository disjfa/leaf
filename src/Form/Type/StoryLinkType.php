<?php

namespace App\Form\Type;

use App\Entity\StoryLink;
use App\Entity\StoryPage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class StoryLinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'constraints' => [
                new NotBlank(),
                new NotNull(),
            ],
        ]);

        $builder->add('storyPage', EntityType::class, [
            'class' => StoryPage::class,
            'choice_label' => 'title',
        ]);

        $builder->add('storyPageTo', EntityType::class, [
            'class' => StoryPage::class,
            'choice_label' => 'title',
            'placeholder' => 'Choose page',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoryLink::class,
        ]);
    }
}
