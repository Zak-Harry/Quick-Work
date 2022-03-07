<?php

namespace App\Form;

use App\Entity\PlannedWorkDays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlannedWorkDaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startshift', DateTimeType::class, [
                'label' => 'Début de journée ',
            ])
            ->add('startlunch', DateTimeType::class, [
                'label' => 'Début de pause repas ',
            ])
            ->add('endlunch', DateTimeType::class, [
                'label' => 'Fin de pause repas ',
            ])
            ->add('endshift', DateTimeType::class, [
                'label' => 'Fin de journée ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlannedWorkDays::class,
        ]);
    }
}
