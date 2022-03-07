<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\PlannedWorkDays;
use App\Entity\User;
use App\Form\PlannedWorkDaysType;
use App\Form\NewPlannedWorkDaysType;
use App\Repository\DepartementRepository;
use App\Repository\PlannedWorkDaysRepository;
use App\Repository\UserRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/planning")
 */
class PlannedWorkDaysController extends AbstractController
{

    /**
     * @Route("/", name="planned_user", methods={"GET"})
     */
    public function userPlanning(): Response
    {
        $userLogged = $this->getUser();

       
       // Call to 'PLANNING_VIEW' from PlanningVoter
       // A user must be logged in to be able to access this page
       // All User Roles can access this page
        $this->denyAccessUnlessGranted('PLANNING_VIEW', $userLogged);


        return $this->render('planning/user.planning.html.twig', [
            'user' => $userLogged,
        ]);
    }
    /**
     * @Route("/departement", name="planned_departement", methods={"GET"})
     */
    public function departementPlanning(UserRepository $user, DepartementRepository $departement): Response
    {

        $userLogged = $this->getUser();
        
         // Call to 'PLANNING_VIEWTEAM' from PlanningVoter
       // A user must be logged in to be able to access this page
       // Only Managers and RH Roles can access this page
       $this->denyAccessUnlessGranted('PLANNING_VIEWTEAM', $userLogged);
        
        $departementId = $userLogged->getDepartement()->getId();
        $dpt = $departement->find($departementId);
        $departementUser = $user->findBy(['departement' => $dpt]);
        $nbUser = (count($departementUser)-1);

        return $this->render('planning/departement.planning.html.twig', [
            'dpt' => $dpt,
            'dptUser' => $departementUser,
            'nbUser' => $nbUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="planned_work_days_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PlannedWorkDays $plannedWorkDay, EntityManagerInterface $entityManager): Response
    {
    
        $form = $this->createForm(PlannedWorkDaysType::class, $plannedWorkDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('planned_departement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planned_work_day' => $plannedWorkDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="planned_work_days_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plannedWorkDay = new PlannedWorkDays();
        $form = $this->createForm(NewPlannedWorkDaysType::class, $plannedWorkDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plannedWorkDay);
            $entityManager->flush();

            return $this->redirectToRoute('planned_departement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/new.html.twig', [
            'planned_work_day' => $plannedWorkDay,
            'form' => $form,
        ]);
    }
}
