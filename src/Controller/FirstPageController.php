<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController extends AbstractController
{
    /**
     * @Route("/home", name="first_page")
     */
    public function index(): Response
    {
        return $this->render('first_page/index.html.twig', [
            'controller_name' => 'FirstPageController',
        ]);
    }
}
