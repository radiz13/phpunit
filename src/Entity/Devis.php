<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    public function isNew()
    {
        return !$this->id;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $number = null;

    /**
     * @var Collection<int, DevisDesign>
     */
    #[ORM\OneToMany(targetEntity: DevisDesign::class, mappedBy: 'devis', cascade: ['persist', 'remove'])]
    private Collection $designs;

    public function __construct()
    {
        $this->designs = new ArrayCollection();
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return Collection<int, DevisDesign>
     */
    public function getDesigns(): Collection
    {
        return $this->designs;
    }

    public function addDesign(DevisDesign $design): static
    {
        if (!$this->designs->contains($design)) {
            $this->designs->add($design);
            $design->setDevis($this);
        }

        return $this;
    }

    public function removeDesign(DevisDesign $design): static
    {
        if ($this->designs->removeElement($design)) {
            // set the owning side to null (unless already changed)
            if ($design->getDevis() === $this) {
                $design->setDevis(null);
            }
        }

        return $this;
    }
}
