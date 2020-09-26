<?php

namespace App\Entity;

use App\Repository\ContainerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ContainerRepository::class)
 */
class Container
{
    const STATUS_RESERVE = 'Reserve';
    const STATUS_FILLING = 'Filling';
    const STATUS_FILLED = 'Filled';
    const STATUS_EMPTY = 'Empty';
    const STATUS_READY_PRODUCT = 'Ready product';
    
    const STATUSES = [
        self::STATUS_RESERVE => self::STATUS_RESERVE,
        self::STATUS_EMPTY => self::STATUS_EMPTY,
        self::STATUS_FILLED => self::STATUS_FILLED,
        self::STATUS_FILLING => self::STATUS_FILLING,
        self::STATUS_READY_PRODUCT => self::STATUS_READY_PRODUCT,
    ];

    const CONTENTS_MATERIAL = 'Material';
    const CONTENTS_PRODUCT = 'Product';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue  
     * @ORM\Column(type="integer")
     * @Groups({"serialize"})
     */
    private $id;

    /**
     * @Assert\Choice({"Reserve", "Filling", "Filled", "Empty", "Ready product"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"serialize", "container:update"})
     */
    private $status;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"serialize", "container:write", "container:update"})
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"serialize", "container:write", "container:update"})
     */
    private $externalId;

    /**
     * @ORM\OneToMany(targetEntity=Action::class, mappedBy="container", orphanRemoval=true)
     */
    private $actions;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "container:update"})
     */
    private $x;

    /**
     * @ORM\Column(type="float")
     * @Groups({"serialize", "container:update"})
     */
    private $y;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="containers")
     */
    private $place;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @Assert\Choice({"Material", "Product"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contents;

    public function __construct()
    {
        $this->actions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return Collection|Action[]
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions[] = $action;
            $action->setContainer($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->contains($action)) {
            $this->actions->removeElement($action);
            // set the owning side to null (unless already changed)
            if ($action->getContainer() === $this) {
                $action->setContainer(null);
            }
        }

        return $this;
    }

    public function getX(): ?float
    {
        return $this->x1;
    }

    public function setX(float $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function setY(float $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(?string $contents): self
    {
        $this->contents = $contents;

        return $this;
    }
}
