<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Entity\PlannedWorkDays;
use App\Entity\User;
use App\Form\PlannedWorkDaysType;
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
    public function index(): Response
    {
        
        function dateToFrench($date, $format) 
        {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
        }
        
        $date = dateToFrench('02-03-2022', "l m F Y");
        $userLogged = $this->getUser();
        return $this->render('planning/user.planning.html.twig', [
            'user' => $userLogged,
            'date' => $date,
        ]);
    }
    /**
     * @Route("/departement/{id}", name="planned_departement", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function departement(UserRepository $user, DepartementRepository $departement, int $id): Response
    {

        $dpt = $departement->find($id);

        $departementUser = $user->findBy(['departement' => $dpt]);
        
        $userLogged = $this->getUser();
        return $this->render('planning/departement.planning.html.twig', [
            'dpt' => $dpt,
            'dptUser' => $departementUser,
        ]);
    }

    /**
     * @Route("/new", name="planned_work_days_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plannedWorkDay = new PlannedWorkDays();
        $form = $this->createForm(PlannedWorkDaysType::class, $plannedWorkDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plannedWorkDay);
            $entityManager->flush();

            return $this->redirectToRoute('planned_work_days_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/new.html.twig', [
            'planned_work_day' => $plannedWorkDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="planned_work_days_show", methods={"GET"})
     */
    public function show(PlannedWorkDays $plannedWorkDay): Response
    {
        return $this->render('planning/show.html.twig', [
            'planned_work_day' => $plannedWorkDay,
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

            return $this->redirectToRoute('planned_work_days_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('planning/edit.html.twig', [
            'planned_work_day' => $plannedWorkDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="planned_work_days_delete", methods={"POST"})
     */
    public function delete(Request $request, PlannedWorkDays $plannedWorkDay, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plannedWorkDay->getId(), $request->request->get('_token'))) {
            $entityManager->remove($plannedWorkDay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('planned_work_days_index', [], Response::HTTP_SEE_OTHER);
    }
}
