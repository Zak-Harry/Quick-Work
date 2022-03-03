<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use DateTimeZone;
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
        // $today = new DateTime('now' , new DateTimeZone('Europe/Paris'));

        setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
        $today = strftime("%A %d %B %Y");        

        // Je retourne à la vue l'utilisateur connecté
        return $this->render('home/index.html.twig', [
            'user' => $user,
            'today' => $today
        ]);
    }
}
