<?php

namespace App\Controller;

use App\Entity\PlannedWorkDays;
use App\Entity\User;
use App\Form\PlannedWorkDaysType;
use App\Repository\PlannedWorkDaysRepository;
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
     * @Route("/", name="planned_work_days_index", methods={"GET"})
     */
    public function index(): Response
    {
        $userLogged = $this->getUser();
        return $this->render('planned_work_days/index.html.twig', [
            'user' => $userLogged,

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

        return $this->renderForm('planned_work_days/new.html.twig', [
            'planned_work_day' => $plannedWorkDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="planned_work_days_show", methods={"GET"})
     */
    public function show(PlannedWorkDays $plannedWorkDay): Response
    {
        return $this->render('planned_work_days/show.html.twig', [
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

        return $this->renderForm('planned_work_days/edit.html.twig', [
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
