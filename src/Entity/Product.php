<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    const TYPE_SPECIAL = 'food';
    const TVA_SPECIAL = 0.055;
    const TVA_NORMAL = 0.196;

    public function computeTVA()
    {
        if ($this->price < 0) throw new \Exception('Je lance une exception');

        if (self::TYPE_SPECIAL == $this->type) {
            return $this->price * self::TVA_SPECIAL;
        }
        return $this->price * self::TVA_NORMAL;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductTechno $techno = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductMarque $marque = null;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getTechno(): ?ProductTechno
    {
        return $this->techno;
    }

    public function setTechno(?ProductTechno $techno): static
    {
        $this->techno = $techno;

        return $this;
    }

    public function getMarque(): ?ProductMarque
    {
        return $this->marque;
    }

    public function setMarque(?ProductMarque $marque): static
    {
        $this->marque = $marque;

        return $this;
    }
}
