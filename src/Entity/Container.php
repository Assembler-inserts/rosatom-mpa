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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"serialize"})
     */
    private $id;

    /**
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
}
