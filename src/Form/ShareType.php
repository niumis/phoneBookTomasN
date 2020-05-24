<?php

namespace App\Form;

use App\Entity\Shared;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ShareType
 *
 * @package App\Form
 */
class ShareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'sharedWithUser',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => 'username',
                    'placeholder' => 'select_user_you_share',
                    'query_builder' => function (UserRepository $repository) {
                        return $repository->createQueryBuilder('u');
                    },
                    'label' => false,
                    'expanded' => false,
                    'multiple' => false,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Shared::class,
            ]
        );
    }
}
