<?php

namespace App\Entity;

use App\Repository\ClusterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClusterRepository::class)]
class Cluster
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 100)]
    private string $name = '';

    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    #[ORM\OneToMany(mappedBy: 'cluster', targetEntity: Category::class)]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setCluster($this);
        }

        return $this;
    }

    // public function removeCategory(Category $category): self
    // {
    //     if ($this->categories->removeElement($category)) {
    //         // set the owning side to null (unless already changed)
    //         if ($category->getCluster() === $this) {
    //             $category->setCluster(null);
    //         }
    //     }

    //     return $this;
    // }
}
