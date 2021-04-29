<?php

namespace App\Entity;

use App\Repository\ProduitCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitCommandeRepository::class)
 */
class ProduitCommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="produitCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Commande;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="produitCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $Quantite;

    /**
     * @ORM\Column(type="integer")
     */
    private $PrixProduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $CoutProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    public function getPrixProduit(): ?int
    {
        return $this->PrixProduit;
    }

    public function setPrixProduit(int $PrixProduit): self
    {
        $this->PrixProduit = $PrixProduit;

        return $this;
    }

    public function getCoutProduit(): ?int
    {
        return $this->CoutProduit;
    }

    public function setCoutProduit(int $CoutProduit): self
    {
        $this->CoutProduit = $CoutProduit;

        return $this;
    }
}
