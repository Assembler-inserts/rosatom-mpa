<?php

namespace App\Controller\Api;

use App\Entity\Tower;
use App\Repository\TowerRepository;
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
 * Class TowerController.
 *
 * @SWG\Tag(name="Tower")
 * @Security(name="Bearer")
 *
 * @Rest\Route("tower")
 * @Rest\View(serializerGroups={"serialize"})
 */
class TowerController extends AbstractFOSRestController
{
    private TowerRepository $towerRepository;
    private EntityManagerInterface $em;

    public function __construct(
        TowerRepository $towerRepository,
        EntityManagerInterface $em
    ) {
        $this->towerRepository = $towerRepository;
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
     *         @SWG\Items(ref=@Model(type=Tower::class, groups={"serialize"}))
     *     )
     * )
     *
     * @Rest\Get("")
     */
    public function list(): View
    {
        $towers = $this->towerRepository->findAll();

        return $this->view($towers, Response::HTTP_OK);
    }

    /**
     * Get object.
     * This call takes into account one object.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Tower::class, groups={"serialize"})
     * )
     *
     * @Rest\Get("/{id}")
     */
    public function one(Tower $tower): View
    {
        return $this->view($tower, Response::HTTP_OK);
    }

    /**
     * Create object.
     * This call creates a new object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Tower::class, groups={"tower:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=201,
     *     description="Returns created object",
     *     @Model(type=Tower::class, groups={"serialize"})
     * )
     *
     * @Rest\Post("")
     * @ParamConverter("tower", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"tower:write"}}})
     */
    public function post(Tower $tower, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($tower);
        $this->em->flush();

        return $this->view($tower, Response::HTTP_CREATED);
    }

    /**
     * Update object.
     * This call updates the object.
     *
     * @SWG\Parameter(name="object", in="body", @Model(type=Tower::class, groups={"tower:write"}), description="Fields of object")
     * @SWG\Response(
     *     response=200,
     *     description="Returns one object",
     *     @Model(type=Tower::class, groups={"serialize"})
     * )
     *
     * @Rest\Patch("/{id}")
     * @ParamConverter("tower", converter="fos_rest.request_body", options={"deserializationContext": {"groups": {"tower:write"}}})
     */
    public function patch(Tower $tower, ConstraintViolationListInterface $validationErrors): View
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($tower);
        $this->em->flush();

        return $this->view($tower, Response::HTTP_OK);
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
    public function delete(Tower $tower): View
    {
        $this->em->remove($tower);
        $this->em->flush();

        return $this->view([], Response::HTTP_OK);
    }
}