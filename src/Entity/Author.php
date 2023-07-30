<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: AvisClient::class, orphanRemoval: true)]
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

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

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
            $avisClient->setAuthor($this);
        }

        return $this;
    }

    public function removeAvisClient(AvisClient $avisClient): static
    {
        if ($this->avisClients->removeElement($avisClient)) {
            // set the owning side to null (unless already changed)
            if ($avisClient->getAuthor() === $this) {
                $avisClient->setAuthor(null);
            }
        }

        return $this;
    }
}
