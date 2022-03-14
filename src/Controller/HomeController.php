<?php

namespace App\Controller;

use DateTime;
use DateTimeZone;
use App\Entity\User;
use DateTimeImmutable;
use App\Entity\EffectiveWorkDays;
use App\Repository\EffectiveWorkDaysRepository;
use App\Repository\PlannedWorkDaysRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(UserRepository $user, EffectiveWorkDaysRepository $effectiverepo, PlannedWorkDaysRepository $plannedRepo): Response
    {
        // TODO : Créer un service ou un listener pour déclencher cette action a chaque tentative d'accès à une page
        // Je m'assure qu'un utilisateur est correctement connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Je récupère l'utilisateur connecté
        $user = $this->getUser();
        
        // Envoie de la date du jour en français
        setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
        $today = strftime("%A %d %B %Y"); 
               
        // Récupère le pointage du user connecté
        $effectiveWorkUser = $effectiverepo->findBy([ 'user' => $user->getId() ]);
        //dd($effectiveWorkUser);

            /*
            array:1 [▼
            0 => App\Entity\EffectiveWorkDays {#187 ▼
                -id: 211
                -startlog: DateTime @1646924914 {#878 ▶}
                -startlunch: null
                -endlunch: null
                -endlog: null
                -hoursworked: null
                -createdAt: null
                -updatedAt: null
            */
            //($effectiveWorkUser[0]->getStartlog());

        
            // Stocke l'objet datetime au format Y-m-d
        
        
        //! ON STOCKE LE JOUR MOI ANNEE
        $dateTimeToday = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $dateTimeToday = $dateTimeToday->format('Y-m-d');

        //! ON RECUPERE LE PLANNING DU USER AVEC LA DATE RECHERCHEE
        //si pas de planning trouvé retourne FALSE
        $userPlannedThisDay = $plannedRepo->findOneUserPlanning($user->getId() , "2022-03-14");
        $userEffectiveWork = $effectiverepo->findEffectiveWorkUser($user->getId() , $dateTimeToday);
        //dd($userEffectiveWork);

        //! Si utilisateur planifié ce jour alors j'affiche sur l'index les pointages

        if(is_array($userPlannedThisDay)){

            // parcours les heures effectives du user pour que la date du jour coincide avec le pointage du jour
            // si coincide, retourne à la vue les pointages du jour
            //for( $i = 0 ; $i < count($effectiveWorkUser) ; $i++){
            //    if( $dateTimeToday === $effectiveWorkUser[$i]->getStartlog()->format('Y-m-d') ) {
                
                    // Je retourne à la vue l'utilisateur connecté
                    return $this->render('home/index.html.twig', [
                        'user' => $user,
                        'today' => $today,
                        'dateTimeToday' => $dateTimeToday,
                        'userEffectiveWork' => $userEffectiveWork
                        ]);
                }
            
        else {
            return $this->render('home/index.html.twig', [
                'user' => $user,
                'today' => $today,
                'dateTimeToday' => $dateTimeToday,
                'userEffectiveWork' => $userEffectiveWork
                ]);
        }
    
    }

    /**
     * Méthode pour ajout en BDD de l'évènement cliqué début de journée
     * 
     * @Route("/log/startlog" , name="startlog", methods={"POST"})
     * @return void
     */
    public function startLog(Request $request, EntityManagerInterface $doctrine, EffectiveWorkDaysRepository $effectiverepo): Response
    {
        $user = $this->getUser();
    
        // Stocke la date et l'heure 
        $shift = new DateTime('now', new DateTimeZone('Europe/Paris'));
           
        // Formate le datetime en année / mois / jour 
        $dateTimeToday = $shift->format('Y-m-d');

        
        // Récupère le pointage (si existant) du user connecté
        $userEffectiveWork = $effectiverepo->findEffectiveWorkUser($user->getId() , $dateTimeToday);
        
         //! Si user n'a pas cliqué sur début de journée alors je l'enregistre en BDD
            if( $userEffectiveWork === false ) {
                $effectiveWorkModel = new EffectiveWorkDays();
                $effectiveWorkModel->setStartlog($shift);
                $effectiveWorkModel->setCreatedAt($shift);

                $doctrine->persist($effectiveWorkModel->setUser($user));
                $doctrine->flush();

                return $this->json(
                    json_encode($effectiveWorkModel),
                    200
                );
            }
             //! Sinon si user a déjà un startLog je ne rentre rien en BDD
            else {
                return $this->json(
                    json_encode('debut de journee deja fait'),
                    200
                );
            }
        }
    
}
