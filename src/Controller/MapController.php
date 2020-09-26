<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    public function __construct()
    {
    }

    /**
     * @Route("/map", name="index")
     */
    public function index(
    ): Response {
        return $this->render('map/index.html.twig');
    }
}