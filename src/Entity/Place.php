<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"serialize", "place:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"serialize", "place:write"})
     */
    private $row;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"serialize", "place:write"})
     */
    private $col;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"serialize", "place:write"})
     */
    private $type;

    /**
     * @Groups({"serialize", "place:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $inputStatus;

    /**
     * @Groups({"serialize", "place:write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $outputStatus;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "place:write"})
     */
    private $x1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "place:write"})
     */
    private $x2;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "place:write"})
     */
    private $y1;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "place:write"})
     */
    private $y2;

    /**
     * @ORM\ManyToOne(targetEntity=Area::class, inversedBy="places")
     * @Groups({"serialize", "place:write"})
     */
    private $area;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(?int $row): self
    {
        $this->row = $row;

        return $this;
    }

    public function getCol(): ?int
    {
        return $this->col;
    }

    public function setCol(?int $col): self
    {
        $this->col = $col;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInputStatus(): ?string
    {
        return $this->inputStatus;
    }

    public function setInputStatus(?string $inputStatus): self
    {
        $this->inputStatus = $inputStatus;

        return $this;
    }

    public function getOutputStatus(): ?string
    {
        return $this->outputStatus;
    }

    public function setOutputStatus(?string $outputStatus): self
    {
        $this->outputStatus = $outputStatus;

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

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }
}
