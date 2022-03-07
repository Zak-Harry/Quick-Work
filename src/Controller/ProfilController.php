<?php

namespace App\Controller;

use App\Classes\formProfil;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\SearchProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
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
        return $this->renderForm('profil/profilform.html.twig',
            [
                'profil' => $profilForm
            ]);
    }

    /**
     * @Route("/profil/search", name="profil_search")
     * @IsGranted("ROLE_RH")
     * @param UserRepository $userRepository
     * @param Request $request
     * @return Response
     */
    public function searchProfil(UserRepository $userRepository, Request $request): Response
    {
        $formSearch = $this->createForm(SearchProfilType::class);
        $formSearch->handleRequest($request);

        if($formSearch->isSubmitted() && $formSearch->isValid())
        {
            $salarie = $request->request->all()["search_profil"]["salarie"];
            $username = explode(' ', $salarie);
            $firstname = $username[0];
            $lastname = $username[1];
            $query = $userRepository->findBy(array("firstname" => $firstname, "lastname" => $lastname));
            dump($query);
            if(empty($query))
            {
                dd($query = $userRepository->findBy(array("firstname" => $lastname, "lastname" => $firstname)));
            }
        }

        return $this->renderForm('profil/profilsearch.html.twig',
            [
                "search" => $formSearch
            ]);
    }

    /**
     * Show all profil by team user
     * Redirige vers la page profil/profilteam.html.twig
     * @Route("/profil/myteam", name="profil_my_team")
     * @return void
     */
    public function profilByTeam(UserRepository $userRepository): Response
    {
        return $this->render('profil/profilteam.html.twig', [
            'teams' => $userRepository->findByTeamDQL($this->getUser()->getDepartement()->getid())
        ]);
    }
}