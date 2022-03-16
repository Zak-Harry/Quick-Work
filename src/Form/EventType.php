<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Congé' => 1,
                    'Formation' => 2,
                    'Maladie' => 3
                ]
            ])
            ->add('startEvent', DateTimeType::class, [

            ])
            ->add('endEvent', DateTimeType::class, [

            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 1,
                    'Validé' => 2,
                    'Annulé' => 3,
                    'Rejeté' =>4
                ]
            ])
            ->add('message', TextType::class)
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
