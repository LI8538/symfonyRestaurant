<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: AvisClient::class)]
    private Collection $avisClients;

    public function __construct()
    {
        $this->avisClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, AvisClient>
     */
    public function getAvisClients(): Collection
    {
        return $this->avisClients;
    }

    public function addAvisClient(AvisClient $avisClient): static
    {
        if (!$this->avisClients->contains($avisClient)) {
            $this->avisClients->add($avisClient);
            $avisClient->setCategory($this);
        }

        return $this;
    }

    public function removeAvisClient(AvisClient $avisClient): static
    {
        if ($this->avisClients->removeElement($avisClient)) {
            // set the owning side to null (unless already changed)
            if ($avisClient->getCategory() === $this) {
                $avisClient->setCategory(null);
            }
        }

        return $this;
    }
}
