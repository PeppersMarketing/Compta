<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Numero;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AdresseLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $VilleLivraison;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CodePostalLivraison;

    /**
     * @ORM\Column(type="integer")
     */
    private $TotalHT;

    /**
     * @ORM\Column(type="integer")
     */
    private $TVA;

    /**
     * @ORM\Column(type="integer")
     */
    private $TotalTTC;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Livraison;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\OneToMany(targetEntity=ProduitCommande::class, mappedBy="Commande", orphanRemoval=true)
     */
    private $produitCommandes;

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): self
    {
        $this->Numero = $Numero;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->AdresseLivraison;
    }

    public function setAdresseLivraison(?string $AdresseLivraison): self
    {
        $this->AdresseLivraison = $AdresseLivraison;

        return $this;
    }

    public function getVilleLivraison(): ?string
    {
        return $this->VilleLivraison;
    }

    public function setVilleLivraison(?string $VilleLivraison): self
    {
        $this->VilleLivraison = $VilleLivraison;

        return $this;
    }

    public function getCodePostalLivraison(): ?string
    {
        return $this->CodePostalLivraison;
    }

    public function setCodePostalLivraison(?string $CodePostalLivraison): self
    {
        $this->CodePostalLivraison = $CodePostalLivraison;

        return $this;
    }

    public function getTotalHT(): ?int
    {
        return $this->TotalHT;
    }

    public function setTotalHT(int $TotalHT): self
    {
        $this->TotalHT = $TotalHT;

        return $this;
    }

    public function getTVA(): ?int
    {
        return $this->TVA;
    }

    public function setTVA(int $TVA): self
    {
        $this->TVA = $TVA;

        return $this;
    }

    public function getTotalTTC(): ?int
    {
        return $this->TotalTTC;
    }

    public function setTotalTTC(int $TotalTTC): self
    {
        $this->TotalTTC = $TotalTTC;

        return $this;
    }

    public function getLivraison(): ?int
    {
        return $this->Livraison;
    }

    public function setLivraison(?int $Livraison): self
    {
        $this->Livraison = $Livraison;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    /**
     * @return Collection|ProduitCommande[]
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setCommande($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getCommande() === $this) {
                $produitCommande->setCommande(null);
            }
        }

        return $this;
    }
}
