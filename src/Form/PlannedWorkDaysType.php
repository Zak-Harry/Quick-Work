<?php

namespace App\Form;

use App\Entity\PlannedWorkDays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlannedWorkDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startshift')
            ->add('endshift')
            ->add('startlunch')
            ->add('endlunch')
            ->add('hoursplanned')
            ->add('createdAt')
            ->add('updadedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlannedWorkDays::class,
        ]);
    }
}
