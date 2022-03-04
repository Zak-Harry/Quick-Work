<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(): Response
    {
        // TODO : Créer un service ou un listener pour déclencher cette action a chaque tentative d'accès à une page
        // Je m'assure qu'un utilisateur est correctement connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Je récupère l'utilisateur connecté
        $user = $this->getUser();

        // Je retourne à la vue l'utilisateur connecté
        return $this->render('home/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/hourly_score/start_shift", name="start_shift")
     * @Route("/hourly_score/start_lunch", name="start_lunch")
     * @Route("/hourly_score/end_lunch", name="end_lunch")
     * @Route("/hourly_score/end_shift", name="end_shift")
     * @return void
     */
    public function hourlyScore()
    {
        // récupérer jour et heure du pointage
        // confirmer que le pointage envoyé est bien celui de l'User Co
        // Si start lunch, vérifié que start shift est présent
        // Si end lunch, vérifié que start shift est présent et start lunch aussi
        // si en shift, vérifié que start shift est présent
        // réactiver les boutons le jour suivant
        // envoyer cette DATA en BDD
    }
}
