<?php

namespace App\Controller\Api;

use App\Entity\Building;
use App\Repository\BuildingRepository;
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
 * Class BuildingController.
 *
 * @SWG\Tag(name="Building")
 * @Security(name="Bearer")
 *
 * @Rest\Route("building")
 * @Rest\View(serializerGroups={"serialize"})
 */
class BuildingController extends AbstractFOSRestController
{
    private BuildingRepository $buildingRepository;
    private EntityManagerInterface $em;

    public function __construct(
        BuildingRepository $buildingRepository,
        EntityManagerInterface $em
    ) {
        $this->buildingRepository = $buildingRepository;
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
     *         @SWG\Items(ref=@Model(type=Building::class, groups={"serialize"}))
     *     )
     * )
     *
     * @Rest\Get("")
     */
    public function list(): View
    {
        $buildings = $this->buildingRepository->findAll();

        return $this->view($buildings, Response::HTTP_OK);
    }

    /**
     * Get object.
     * This call takes into account one object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Building::class, groups={"serialize"})
     * )
     *
     * @Rest\Get("/{id}")
     */
    public function one(Building $building): View
    {
        return $this->view($building, Response::HTTP_OK);
    }

    /**
     * Create object.
     * This call creates a new object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Building::class, groups={"building:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=201,
     *     description="Returns created object",
     *     @Model(type=Building::class, groups={"serialize"})
     * )
     *
     * @Rest\Post("")
     * @ParamConverter("building", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"building:write"}}})
     */
    public function post(Building $building, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($building);
        $this->em->flush();

        return $this->view($building, Response::HTTP_CREATED);
    }

    /**
     * Update object.
     * This call updates the object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Building::class, groups={"building:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Building::class, groups={"serialize"})
     * )
     *
     * @Rest\Patch("/{id}")
     * @ParamConverter("building", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"building:write"}}})
     */
    public function patch(Building $building, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($building);
        $this->em->flush();

        return $this->view($building, Response::HTTP_OK);
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
    public function delete(Building $building): View
    {
        $this->em->remove($building);
        $this->em->flush();

        return $this->view([], Response::HTTP_OK);
    }
}