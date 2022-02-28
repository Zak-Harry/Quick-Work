<?php

namespace App\Form;

use App\Entity\Documentation;
use App\Entity\EffectiveWorkDays;
use App\Entity\Job;
use App\Entity\PlannedWorkDays;
use App\Entity\Role;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom du salarié',
                'placeholder' => 'Merci de renseigner le nom du salarié',
                'trim' => true,
                'required' => true
            ])
            ->add('firstname', TextType::class,
                [
                'default_protocol' =>  'HTTP, HTTPS',
                'label' => 'Prénom du salarié',
                'placeholder' => 'Merci de renseigner le prénom du salarié',
                'trim' => true,
                'required' => true
            ])
            ->add('picture', UrlType::class, [
                'label' => 'Photo du salarié',
                'placeholder' => 'Merci de mettre la photo du salarié',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email personnel du salarié',
                'placeholder' => 'Merci de mettre l\'Email personnel du salarié',
                'required' => true
            ])
            ->add('emailpro', EmailType::class, [
                'label' => 'Email professionnelle du salarié',
                'placeholder' => 'Merci de mettre l\'Email professionnelle du salarié',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'always_empty' => false,
                'trim' => true,
                'label' => 'Votre mot de passe',
                'placeholder' => 'Renseigner votre mot de passe',
                'required' => true,
            ])
            ->add('phonenumber', TextType::class, [
                'label' => 'Numéro de téléphone personnel',
                'placeholder' => 'Merci de renseigner le N° de téléphone personnel du salarié',
                'required' => true
            ])
            ->add('phonenumberpro', TextType::class, [
                'label' => 'Numéro de téléphone professionnel',
                'placeholder' => 'Merci de renseigner le N° de téléphone professionnel du salarié',
                'required' => true
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse du salarié',
                'placeholder' => 'Merci de renseigner l\'adresse du salarié',
                'required' => true
            ])
            ->add('city',  TextType::class, [
                'label' => 'Votre ville',
                'placeholder' => 'Merci de renseigner le nom de votre ville d\'habitation',
                'required' => true
            ])
            ->add('zipcode',  TextType::class, [
                'label' => 'Code postal',
                'placeholder' => 'Merci de renseigner le code postal de votre adresse d\'habitation',
                'required' => true
            ])
            ->add('rib',  TextType::class, [
                'label' => 'Votre Relevé d\'identité bancaire',
                'placeholder' => 'Merci de renseigner le relevé d\'identité bancaire du salarié',
                'required' => true
            ])
            ->add('status')
            ->add('createdAt', DateTimeType::class, [

            ])
            ->add('updatedAt', DateTimeType::class, [
            ])
            ->add('documentations', EntityType::class, [
                'class' => Documentation::class
            ])
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'placeholder' => 'Veuillez un métier'
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class
            ])
            ->add('plannedWorkDays', EntityType::class, [
                'class' => PlannedWorkDays::class
            ])
            ->add('effectiveWorkDays', EntityType::class, [
                'class' => EffectiveWorkDays::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
