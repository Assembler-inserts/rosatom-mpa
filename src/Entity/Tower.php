<?php

namespace App\Entity;

use App\Repository\TowerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TowerRepository::class)
 */
class Tower
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\Column(type="float")
     */
    private $x1;

    /**
     * @ORM\Column(type="float")
     */
    private $x2;

    /**
     * @ORM\Column(type="float")
     */
    private $y1;

    /**
     * @ORM\Column(type="float")
     */
    private $y2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

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
}
