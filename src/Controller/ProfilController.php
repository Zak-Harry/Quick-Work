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
     * @return Response
     */
    public function showProfil(): Response
    {
        $this->denyAccessUnlessGranted('VIEW');
        // Le rendu de cette page se fait sur le template Twig : profil/index.html.twig
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }


    /**
     * Cette méthode permet de créer ou d'éditer une page de profil
     * Le rendu de cette page se fait sur le template Twig : profil/profilform.html.twig
     * @Route("/profil/new", name="profil_new")
     * @Route("/profil/edit/{id}", name="profil_edit")
     * @param EntityManagerInterface $manager
     * @param User|null $user
     * @return Response
     */
    public function formProfil(EntityManagerInterface $manager, User $user = NULL): Response
    {
        // Si pas de USER alors crée un USER, ceci pour l'ajout d'un salarié
        if(!$user)
        {
            // Si utilisateur est RH alors il peut CREATE
            $this->denyAccessUnlessGranted('CREATE');
            $user = new User();
        }

        $profilForm = $this->createForm(ProfilType::class, $user);
        // Si utilisateur est RH ou utilisateur connecte = page de profil demandé alors il peut EDIT
        $this->denyAccessUnlessGranted('EDIT', $profilForm);

        if($profilForm->isSubmitted() && $profilForm->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profil', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('profil/profilform.html.twig',['profil' => $profilForm]);
    }
}