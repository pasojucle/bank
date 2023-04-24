<?php

namespace App\Entity;

use App\Entity\Deadline;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MonthRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MonthRepository::class)]
class Month
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Deadline::class, mappedBy: 'months', )]
    private Collection $deadlines;

    public function __construct()
    {
        $this->deadlines = new ArrayCollection();
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

    /**
     * @return Collection<int, Deadline>
     */
    public function getDeadlines(): Collection
    {
        return $this->deadlines;
    }

    public function addDeadline(Deadline $deadline): self
    {
        if (!$this->deadlines->contains($deadline)) {
            $this->deadlines->add($deadline);
            $deadline->addMonth($this);
        }

        return $this;
    }

    public function removeDeadline(Deadline $deadline): self
    {
        if ($this->deadlines->removeElement($deadline)) {
            $deadline->removeMonth($this);
        }

        return $this;
    }
}
