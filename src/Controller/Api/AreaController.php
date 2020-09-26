<?php

namespace App\Controller\Api;

use App\Entity\Area;
use App\Repository\AreaRepository;
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
 * Class AreaController.
 *
 * @SWG\Tag(name="Area")
 * @Security(name="Bearer")
 *
 * @Rest\Route("area")
 * @Rest\View(serializerGroups={"serialize"})
 */
class AreaController extends AbstractFOSRestController
{
    private AreaRepository $areaRepository;
    private EntityManagerInterface $em;

    public function __construct(
        AreaRepository $areaRepository,
        EntityManagerInterface $em
    ) {
        $this->areaRepository = $areaRepository;
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
     *         @SWG\Items(ref=@Model(type=Area::class, groups={"serialize"}))
     *     )
     * )
     *
     * @Rest\Get("")
     */
    public function list(): View
    {
        $areas = $this->areaRepository->findAll();

        return $this->view($areas, Response::HTTP_OK);
    }

    /**
     * Get object.
     * This call takes into account one object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Area::class, groups={"serialize"})
     * )
     *
     * @Rest\Get("/{id}")
     */
    public function one(Area $area): View
    {
        return $this->view($area, Response::HTTP_OK);
    }

    /**
     * Create object.
     * This call creates a new object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Area::class, groups={"area:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=201,
     *     description="Returns created object",
     *     @Model(type=Area::class, groups={"serialize"})
     * )
     *
     * @Rest\Post("")
     * @ParamConverter("area", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"area:write"}}})
     */
    public function post(Area $area, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($area);
        $this->em->flush();

        return $this->view($area, Response::HTTP_CREATED);
    }

    /**
     * Update object.
     * This call updates the object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Area::class, groups={"area:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Area::class, groups={"serialize"})
     * )
     *
     * @Rest\Patch("/{id}")
     * @ParamConverter("area", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"area:write"}}})
     */
    public function patch(Area $area, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($area);
        $this->em->flush();

        return $this->view($area, Response::HTTP_OK);
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
    public function delete(Area $area): View
    {
        $this->em->remove($area);
        $this->em->flush();

        return $this->view([], Response::HTTP_OK);
    }
}