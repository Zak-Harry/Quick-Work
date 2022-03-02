<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddProfileController extends AbstractController
{
    /**
     * @Route("/add/profile", name="add_profile")
     */
    public function CheckVoterAction(User $user)
    {
        if (!$this->isGranted('USER_VIEW', $user)) {
            throw $this->createAccessDeniedException('NO!');
        }
    }
}



