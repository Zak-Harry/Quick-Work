<?php

namespace App\Controller;

use App\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Event extends AbstractController
{
    /**
     * @Route("/event", name="event")
     * @return Response
     */
    public function index(): Response
    {
        $eventForm = $this->createForm(EventType::class);

        return $this->renderForm('/event/index.html.twig',
            [
            'event' => $eventForm
            ]
        );
    }

}