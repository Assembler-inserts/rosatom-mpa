<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BuildingRepository::class)
 */
class Building
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"serialize", "area:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"serialize", "building:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "building:write"})
     */
    private $x1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "building:write"})
     */
    private $x2;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "building:write"})
     */
    private $y1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "building:write"})
     */
    private $y2;

    /**
     * @ORM\OneToMany(targetEntity=Area::class, mappedBy="building")
     */
    private $areas;

    public function __construct()
    {
        $this->areas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Collection|Area[]
     */
    public function getAreas(): Collection
    {
        return $this->areas;
    }

    public function addArea(Area $area): self
    {
        if (!$this->areas->contains($area)) {
            $this->areas[] = $area;
            $area->setBuilding($this);
        }

        return $this;
    }

    public function removeArea(Area $area): self
    {
        if ($this->areas->contains($area)) {
            $this->areas->removeElement($area);
            // set the owning side to null (unless already changed)
            if ($area->getBuilding() === $this) {
                $area->setBuilding(null);
            }
        }

        return $this;
    }
}
