<?php

namespace App\Controller\Api;

use App\Entity\Place;
use App\Repository\PlaceRepository;
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
 * Class PlaceController.
 *
 * @SWG\Tag(name="Place")
 * @Security(name="Bearer")
 *
 * @Rest\Route("place")
 * @Rest\View(serializerGroups={"serialize"})
 */
class PlaceController extends AbstractFOSRestController
{
    private PlaceRepository $placeRepository;
    private EntityManagerInterface $em;

    public function __construct(
        PlaceRepository $placeRepository,
        EntityManagerInterface $em
    ) {
        $this->placeRepository = $placeRepository;
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
     *         @SWG\Items(ref=@Model(type=Place::class, groups={"serialize"}))
     *     )
     * )
     *
     * @Rest\Get("")
     */
    public function list(): View
    {
        $places = $this->placeRepository->findAll();

        return $this->view($places, Response::HTTP_OK);
    }

    /**
     * Get object.
     * This call takes into account one object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Place::class, groups={"serialize"})
     * )
     *
     * @Rest\Get("/{id}")
     */
    public function one(Place $place): View
    {
        return $this->view($place, Response::HTTP_OK);
    }

    /**
     * Create object.
     * This call creates a new object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Place::class, groups={"place:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=201,
     *     description="Returns created object",
     *     @Model(type=Place::class, groups={"serialize"})
     * )
     *
     * @Rest\Post("")
     * @ParamConverter("place", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"place:write"}}})
     */
    public function post(Place $place, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($place);
        $this->em->flush();

        return $this->view($place, Response::HTTP_CREATED);
    }

    /**
     * Update object.
     * This call updates the object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Place::class, groups={"place:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Place::class, groups={"serialize"})
     * )
     *
     * @Rest\Patch("/{id}")
     * @ParamConverter("place", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"place:write"}}})
     */
    public function patch(Place $place, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($place);
        $this->em->flush();

        return $this->view($place, Response::HTTP_OK);
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
    public function delete(Place $place): View
    {
        $this->em->remove($place);
        $this->em->flush();

        return $this->view([], Response::HTTP_OK);
    }
}