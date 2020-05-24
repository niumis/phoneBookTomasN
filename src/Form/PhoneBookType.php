<?php

namespace App\Form;

use App\Entity\PhoneBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PhoneBookType
 *
 * @package App\Form
 */
class PhoneBookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'fullName',
                null,
                [
                    'label' => 'full_name',
                ]
            )
            ->add(
                'phone',
                null,
                [
                    'label' => 'phone',
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
                'data_class' => PhoneBook::class,
            ]
        );
    }
}
