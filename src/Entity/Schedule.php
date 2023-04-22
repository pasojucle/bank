<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule extends AbstractTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $deadlineDay = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endAt = null;

    #[ORM\ManyToMany(targetEntity: Month::class, inversedBy: 'schedules')]
    private Collection $deadlineMonths;

    public function __construct()
    {
        $this->deadlineMonths = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeadlineDay(): ?int
    {
        return $this->deadlineDay;
    }

    public function setDeadlineDay(int $deadlineDay): self
    {
        $this->deadlineDay = $deadlineDay;

        return $this;
    }

    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, Month>
     */
    public function getDeadlineMonths(): Collection
    {
        return $this->deadlineMonths;
    }

    public function addDeadlineMonth(Month $deadlineMonth): self
    {
        if (!$this->deadlineMonths->contains($deadlineMonth)) {
            $this->deadlineMonths->add($deadlineMonth);
        }

        return $this;
    }

    public function removeDeadlineMonth(Month $deadlineMonth): self
    {
        $this->deadlineMonths->removeElement($deadlineMonth);

        return $this;
    }
}
