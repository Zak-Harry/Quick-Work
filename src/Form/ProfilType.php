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
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ProfilType extends AbstractType
{
    private Security $security;

    private $is_granted;

    public function __construct(Security $security)
    {
        $this->security =  $security;
        $user = $this->security->getUser()->getRoles();
        if ($user != 'ROLE_RH')
        {
            $this->is_granted = true;
        }
        dump($this->is_granted);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'disabled' => $this->is_granted,
                'label' => 'Nom du salarié',
                'trim' => true,
                'required' => true
            ])
            ->add('firstname', TextType::class,
                [
                'disabled' => $this->is_granted,
                'label' => 'Prénom du salarié',
                'trim' => true,
                'required' => true
            ])
            ->add('dateOfBirth', BirthdayType::class, [
                'disabled' => $this->is_granted,
            ])
            ->add('picture', UrlType::class, [
                'disabled' => $this->is_granted,
                'label' => 'Photo du salarié',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email personnel du salarié',
                'required' => true
            ])
            ->add('emailpro', EmailType::class, [
                'disabled' => $this->is_granted,
                'label' => 'Email professionnelle du salarié',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'always_empty' => false,
                'trim' => true,
                'label' => 'Votre mot de passe',
                'required' => true,
            ])
            ->add('phonenumber', TextType::class, [
                'label' => 'Numéro de téléphone personnel',
                'required' => true
            ])
            ->add('phonenumberpro', TextType::class, [
                'disabled' => $this->is_granted,
                'label' => 'Numéro de téléphone professionnel',
                'required' => true
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse du salarié',
                'required' => true
            ])
            ->add('city',  TextType::class, [
                'label' => 'Votre ville',
                'required' => true
            ])
            ->add('zipcode',  TextType::class, [
                'label' => 'Code postal',
                'required' => true
            ])
            ->add('rib',  TextType::class, [
                'label' => 'Votre Relevé d\'identité bancaire',
                'required' => true
            ])
            ->add('status', ChoiceType::class, [
                'disabled' => $this->is_granted,
            ])
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'disabled' => $this->is_granted,
                'multiple' => false,
                'expanded' => false,
                ]
            )
            ->add('job', EntityType::class, [
                'class' => Job::class,
                'disabled' => $this->is_granted,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
            /**
            ->add('createdAt', DateTimeType::class, [
            ])
            ->add('updatedAt', DateTimeType::class, [
            ])
            ->add('documentations', EntityType::class, [
                'class' => Documentation::class
            ]*/
            /**
            ->add('plannedWorkDays', EntityType::class, [
                'class' => PlannedWorkDays::class
            ])
            ->add('effectiveWorkDays', EntityType::class, [
                'class' => EffectiveWorkDays::class
            ])
             */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
