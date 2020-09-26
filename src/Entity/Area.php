<?php

namespace App\Entity;

use App\Repository\AreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AreaRepository::class)
 */
class Area
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"serialize", "place:write"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="areas")
     * @Groups({"serialize", "area:write"})
     */
    private $building;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "area:write"})
     */
    private $x1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "area:write"})
     */
    private $x2;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "area:write"})
     */
    private $y1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "area:write"})
     */
    private $y2;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="area")
     */
    private $places;

    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getX1(): ?float
    {
        return $this->x1;
    }

    public function setX1(float $x1): self
    {
        $this->x1 = $x1;

        return $this;
    }

    public function getX2(): ?float
    {
        return $this->x2;
    }

    public function setX2(float $x2): self
    {
        $this->x2 = $x2;

        return $this;
    }

    public function getY1(): ?float
    {
        return $this->y1;
    }

    public function setY1(float $y1): self
    {
        $this->y1 = $y1;

        return $this;
    }

    public function getY2(): ?float
    {
        return $this->y2;
    }

    public function setY2(float $y2): self
    {
        $this->y2 = $y2;

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setArea($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getArea() === $this) {
                $place->setArea(null);
            }
        }

        return $this;
    }
}
