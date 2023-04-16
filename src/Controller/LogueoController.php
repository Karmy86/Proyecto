<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogueoController extends AbstractController
{
    #[Route('/logueo', name: 'app_logueo')]
    public function index(): Response
    {
        return $this->render('logueo/index.html.twig', [
            'controller_name' => 'LogueoController',
        ]);
    }
}
