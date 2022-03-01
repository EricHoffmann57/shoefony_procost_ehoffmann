<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class MainController extends AbstractController
{
    public function __construct(

    ) {
    }

    #[Route('/', name: 'main_homepage', methods: ['GET'])]
    public function homepage(): Response
    {
        return $this->render('main/index.html.twig', [

        ]);
    }
}