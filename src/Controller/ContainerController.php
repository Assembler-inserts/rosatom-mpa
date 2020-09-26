<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\FilterType;
use App\Repository\ContainerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContainerController extends AbstractController
{
    private ContainerRepository $containerRepository;

    public function __construct(ContainerRepository $containerRepository)
    {
        $this->containerRepository = $containerRepository;
    }

    /**
     * @Route("/container", name="container_list")
     */
    public function list(
        Request $request
    ): Response {
        $filter = [];
        $form = $this->createForm(FilterType::class);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();
        }

        $containers = $this->containerRepository->findForList($filter);

        return $this->render('container/list.html.twig', [
            'containers' => $containers,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/container/{id}", name="container_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $container = $this->containerRepository->find($id);

        if (!$container) {
            throw new NotFoundHttpException();
        }

        return $this->render('container/show.html.twig', [
            'container' => $container,
        ]);
    }
}