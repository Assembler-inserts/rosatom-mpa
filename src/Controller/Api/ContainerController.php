<?php

namespace App\Controller\Api;

use App\Entity\Container;
use App\Repository\ContainerRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ContainerController.
 *
 * @SWG\Tag(name="Container")
 * @Security(name="Bearer")
 *
 * @Rest\Route("container")
 * @Rest\View(serializerGroups={"serialize"})
 */
class ContainerController extends AbstractFOSRestController
{
    private ContainerRepository $containerRepository;
    private EntityManagerInterface $em;

    public function __construct(
        ContainerRepository $containerRepository,
        EntityManagerInterface $em
    ) {
        $this->containerRepository = $containerRepository;
        $this->em = $em;
    }

    /**
     * List of objects.
     * This call takes into account all objects.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns list of objects",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Container::class, groups={"serialize"}))
     *     )
     * )
     *
     * @Rest\Get("")
     */
    public function list(): View
    {
        $containers = $this->containerRepository->findAll();

        return $this->view($containers, Response::HTTP_OK);
    }

    /**
     * Get object.
     * This call takes into account one object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Container::class, groups={"serialize"})
     * )
     *
     * @Rest\Get("/{id}")
     */
    public function one(Container $container): View
    {
        return $this->view($container, Response::HTTP_OK);
    }

    /**
     * Create object.
     * This call creates a new object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Container::class, groups={"container:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=201,
     *     description="Returns created object",
     *     @Model(type=Container::class, groups={"serialize"})
     * )
     *
     * @Rest\Post("")
     * @ParamConverter("container", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"container:write"}}})
     */
    public function post(Container $container, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($container);
        $this->em->flush();

        return $this->view($container, Response::HTTP_CREATED);
    }

    /**
     * Update object.
     * This call updates the object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Container::class, groups={"container:update"}), description="Fields of object")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Container::class, groups={"serialize"})
     * )
     *
     * @Rest\Patch("/{id}")
     * @ParamConverter("container", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"container:update"}}})
     */
    public function patch(Container $container, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($container);
        $this->em->flush();

        return $this->view($container, Response::HTTP_OK);
    }

    /**
     * Delete object.
     * This call removes the object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns empty response"
     * )
     *
     * @Rest\Delete("/{id}")
     */
    public function delete(Container $container): View
    {
        $this->em->remove($container);
        $this->em->flush();

        return $this->view([], Response::HTTP_OK);
    }
}