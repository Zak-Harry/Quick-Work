<?php

namespace App\Controller;

use App\Classes\formProfil;
use App\Entity\User;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{

    /**
     * Affiche la page profil de l'utilisateur actuellement connecté
     * @Route("/profil", name="profil")
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function showProfil(EntityManagerInterface $manager): Response
    {
        // Si utilisateur est USER ou MANAGER alors affiche son profil, bloque CREATE et peut EDIT uniquement son profil

        $profilForm = $this->createForm(ProfilType::class, $this->getUser());

        if($profilForm->isSubmitted() && $profilForm->isValid())
        {
            $manager->persist($this->getUser());
            $manager->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/index.html.twig',['profil' => $profilForm]);
    }


    /**
     * @Route("/profil/new", name="profil_new")
     * @Route("/profil/edit/{id}", name="profil_edit")
     * @param EntityManagerInterface $manager
     * @param User|null $user
     * @return Response
     */
    public function formProfil(EntityManagerInterface $manager, User $user = NULL): Response
    {

        // dd($this->getUser(), $user);
        // Si utilisateur est RH alors il peut EDIT CREATE

        // Si pas de USER alors crée un USER, ceci pour l'ajout d'un salarié
        if(!$user)
        {
            $user = new User();
        }

        $profilForm = $this->createForm(ProfilType::class, $user);

        $this->denyAccessUnlessGranted('PROFIL_CREATE', $profilForm);

        if($profilForm->isSubmitted() && $profilForm->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/index.html.twig',['profil' => $profilForm]);
    }
}